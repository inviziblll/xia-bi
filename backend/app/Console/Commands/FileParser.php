<?php
/**
 * Created by IntelliJ IDEA.
 * User: alexburov
 * Date: 07.05.18
 * Time: 19:03
 */

namespace App\Console\Commands;


use App\ShopGrades;
use Faker\Provider\DateTime;
use Illuminate\Support\Facades\File;

use League\Csv\Reader;
use League\Csv\Statement;
use Mockery\Exception;
use PhpImap\Mailbox;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Coeff;
use App\FileLog;
use App\VisitLog;
use App\StaffPlan;
use App\Shop;
use App\User;
use App\Shift;
use App\ProductGroup;
use App\ProductGroupPlan;
use App\ProductGroupPlanType;
use App\FileType;
use Illuminate\Console\Command;

use App\VisitLogCopy;
use Illuminate\Support\Facades\DB;
// use Carbon\Carbon;
// use Faker\Provider\DateTime;



class FileParser extends Command
{

    /**
     * Имя и аргументы консольной команды.
     *
     * @var string
     */
    protected $signature = 'cron:fileparser';

    /**
     * Описание консольной команды.
     *
     * @var string
     */
    protected $description = 'Parse Email cron task';

    /**
     * Служба "капельных" e-mail сообщений.
     *
     * @var DripEmailer
     */


    /**
     * Создание нового экземпляра команды.
     *
     * @param  DripEmailer  $drip
     * @return void
     */

    /**
     * Выполнение консольной команды.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->file_reader();
    }

    // читаем базу загруженныхна сайт файлов для CRON
    public function file_reader(){

//         dd('---');

        echo "file_reader start \n";
        
        $dateStart = date("Y-m-d H:i:s");
//        sleep(10);

       FileLog::where('status', '0')->update(['status' => 1]);
        $fileLogs =FileLog::where('status', '1')->where('created_at', '<', $dateStart)->get();
        $result = [];
        foreach ($fileLogs as $item){
            echo 'start foreach \n';

            $fileType =  substr($item->file_name, strpos($item->file_name, '.', -4));

            // читаем CSV файл
            $result[] = $this->csvReader($item->path, $item->file_type_id, $item->id, $item->file_name, $item->original_file_name, $item->description);
        }

        // return $fileLogs;
        echo "file_reader and \n";

        // dd($result);
    }

    // читаем CSV документ
    public function csvReader($csv_file, $file_type_id, $file_log_id, $file_name, $original_file_name, $description){


        //        //load the CSV document from a stream
        //        $stream = fopen($csv_file, 'r');
        //        $csv = Reader::createFromStream($stream);
        //
        //
        //        // dd($csv);
        //        $csv->setDelimiter($csv->getDelimiter());
        //        $csv->setHeaderOffset(0);
        //
        // // build a statement
        // $stmt = new Statement();
        // $stmt->offset(10)->limit(25);

        //query your records from the document
        // $records = $stmt->process($csv);
        // $result = false;

        $date = date("Y-m-d H:i:s");
        $fileLog = FileLog::find($file_log_id);

        // $fileLog->update(['parse_date'=>$date]);
        // $jsonResult = json_encode($records, JSON_UNESCAPED_UNICODE);
        // $fileLog->update(['parse_date'=>$date, 'Content'=>$jsonResult, 'status'=>2]);

        $fileDataStr = file_get_contents($csv_file, true);
//        $fileLog->update(['parse_date'=>$date, 'Content'=>$fileDataStr, 'status'=>2]);
//        $fileLog->save();

        // dd($file_name);
        // dd($original_file_name);
        // dd($csv_file);
        // dd($description);
        // dd($fileDataStr);

        $type_code = "Visit";
        $result = DB::select('EXEC Parser_FileLoad ?, ?, ?, ?, ?, ?', array($type_code, $file_name, $original_file_name, $csv_file, $description, $fileDataStr));
        // dd($result);
        $result = true;



//        @FileTypeCode = 'Visit',
//@FileName = '',
//@OriginalFileName = '',
//@Path = '',
//@Description = '',
//@Content  = '<содержимое файла>'
        /*
        print_r($file_type_id);
        if($file_type_id == 2 || $file_type_id == 1){
             $result = $this->writeVisitlog($records, $file_log_id);
        }

        if($file_type_id == 3){
            $result  = $this->writeShopShift($records, $file_log_id);
        }

        if($file_type_id == 4){
            $result = $this->_ProductGroupPlan($records, $file_log_id);
        }
        if($file_type_id == 5){
            $result = $this->coefFile($records, $file_log_id);
        }
        if($file_type_id == 6){

            $result = $this->shopGradeFile($records, $file_log_id);
        }

        // dd($result);

        if(!empty($result)){
            $fileLog->update(['status'=>3]);
            $fileLog->save();
            // dd($fileLog);
        }*/

        return $result;
    }


//    public function test_writeVisitlog($records){
//
//        $logs = [];
//        $i = 0;
//
//
//        foreach ($records as $record) {
//            $i++;
//
////            $item = array(
////                'Название'=>$record['Название'],
////                'Серийный номер'=>$record['Серийный номер'],
////                'Дата'=>$record['Дата'],
////                'День недели'=>$record['День недели'],
////                'Номер недели'=>$record['Номер недели'],
////                'Количество посетителей'=>$record['Количество посетителей']
////            );
//            // $logs[] = $item;
//
//            $logs[] = $record;
//
//            // var_dump($record);
//
//
//        }
//
//        return $logs;
//
//    }



    // запись в Visitlog
    public function writeVisitlog($records, $file_log_id){

        $logs = [];
        $i = 0;
        $step = 0;

        $shops = Shop::all()->toArray();
        $shopRecords = [];

        foreach ($records as $record) {

            $i++;
            $shop_id = 0;

            var_dump($i);

            if($step==0){
                DB::beginTransaction();
                echo "beginTransaction\n";
            }

            if(isset($shopRecords[$record['Название']])){
                $shop_id = $shopRecords[$record['Название']];
            }
            else{

                $key = array_search($record['Название'], array_column($shops, 'mapping_name'));

                if($key){
                    $shopRecords[$record['Название']] = $shops[$key ]['id'];
                    $shop_id = $shops[$key ]['id'];
                }else{

                    $shop = Shop::create([
                        'name'=>$record['Название'],
                        'mapping_name'=>$record['Название'],
                    ])->toArray();
                    $shopRecords[$record['Название']] = $shop['id'];
                    $shop_id = $shop['id'];
                }
            }

            try {

                $date_from = substr($record['Дата'], 0, strrpos($record['Дата'], ' ') - 2);
                $date_from = new \DateTime($date_from);

//                $date_to_date = substr($record['Дата'], 0, 11);
//                $date_to_time = substr($record['Дата'], 19, 24);
//                $date_to = $date_to_date . $date_to_time;
//                $date_to = new \DateTime($date_to);

//                $log = VisitLogCopy::UpdateOrCreate(
//                    ['shop_id' => $shop_id, 'date_from' => $date_from, 'date_to' => $date_to],
//                    ['count' => $record['Количество посетителей']]
//                );

                if(!empty($shop_id)){
                    $log = VisitLog::UpdateOrCreate(
                        ['shop_id' => $shop_id, 'date' => $date_from],
                        ['count' => $record['Количество посетителей']]
                    );
                }


                // dd($log);

                $logs[] = $log->toArray()['id'];

            }catch(Exception $e){
                DB::rollBack();
                $this->info($e->getMessage());
                DB::rollBack();
               FileLog::find($file_log_id)->fill(['status'=>2,'description'=>$e->getMessage()])->save();
            }

            if($step==10){
                DB::commit();
                $step = 0;
                echo "commit\n";
                // ставим замедление
                usleep(50000);

            }else{
                $step++;

            }

        }

        DB::commit();
        return $logs;
    }


    // запись в ShopShift
    public function writeShopShift($records, $file_log_id){

        // счетчики
        $i = 0;
        $step = 0;

        // массивы сущностей
        $shops = Shop::all()->toArray();
        $shifts = Shift::all()->toArray();
        $users = User::all()->toArray();

        $shopRecords = []; // $shops = [];
        $shiftRecords = []; // $shifts = [];
        $userRecords = []; // $users = [];
        $shop_shifts = [];

        // $test = Shop::where('mapping_name', 'Магазин № 02/001 (ТЦ Мир) Уфа')->first();
        // $test = Shop::where('mapping_name', 'Калининград, Черняховского 6А')->first();

        foreach ($records as $record) {

            $shop_id = 0;
            $shift_id = 0;
            $user_id = 0;

            $i++;

            var_dump($i);

                    if($step==0){
                        DB::beginTransaction();
                        echo "beginTransaction\n";

                    }

                    try {

                            if(isset($shopRecords[$record['магазин']])){
                                        $shop_id = $shopRecords[$record['магазин']];
                            }
                            else{

                                // dd($record['магазин']);

                                $key = array_search($record['магазин'], array_column($shops, 'mapping_name'));

                                // dd($key);

                                if($key){
                                    $shopRecords[$record['магазин']] = $shops[$key]['id'];
                                    $shop_id = $shops[$key ]['id'];
                                }else{
                                    $shop = Shop::create([
                                        'name'=>$record['магазин'],
                                        'mapping_name'=>$record['магазин'],
                                    ])->toArray();

                                    $shopRecords[$record['магазин']] = $shop['id'];
                                    $shop_id = $shop['id'];

                                }
                            }

                            // dd($shop_id);


                            if(isset($shiftRecords[$record['Смена']])){
                                $shift_id = $shiftRecords[$record['Смена']];
                            }
                            else{

                                $key = array_search($record['Смена'], array_column($shifts, 'name'));
                                if($key){
                                    $shiftRecords[$record['Смена']] = $shifts[$key]['id'];
                                    $shift_id = $shifts[$key]['id'];
                                }else{
                                    $shift = Shift::create([
                                        'name'=>$record['Смена']
                                    ])->toArray();
                                    $shiftRecords[$record['Смена']] = $shift['id'];
                                    $shift_id = $shift['id'];

                                }
                            }


                            if(isset($userRecords[$record['ФИО продавца']])){
                                $user_id = $userRecords[$record['ФИО продавца']];
                            }
                            else{

                                $key = array_search($record['ФИО продавца'], array_column($users, 'name'));
                                if($key){
                                    $userRecords[$record['ФИО продавца']] = $users[$key]['id'];
                                    $user_id = $users[$key]['id'];
                                }else{

                                    $user = User::create([
                                        'name'=>$record['ФИО продавца']
                                    ])->toArray();
                                    $user_id = $user['id'];
                                    $userRecords[$record['ФИО продавца']] = $user['id'];

                                }

                            }

                            if($user_id && $shop_id && $shift_id){

                                // $date = date_format(date_create($record['День']),"Y-m-d H:i:s");
                                $date = new \DateTime($record['День']);

                                // проверка по пользователю и смене
                                $shopShift = StaffPlan::UpdateOrCreate([
                                    'shop_id' => $shop_id,
                                    'user_id'=> $user_id,
                                    'shift_id'=> $shift_id
                                ],[
                                    'role_id'=> 1,
                                    'date'=> $date
                                ]);

                                // dd($shopShift);

                                $shop_shifts[] = $shopShift->toArray();
                            }

                    }catch(Exception $e){
                        $this->info($e->getMessage());
                        DB::rollBack();
                       FileLog::find($file_log_id)->fill(['status'=>2,'description'=>$e->getMessage()])->save();
                    }

                    if($step==10){

                        DB::commit();
                        $step = 0;
                        echo "commit\n";

                        usleep(50000);

                    }else{
                        $step++;

                    }

        }

        DB::commit();
        return $shop_shifts;

    }

    public function coefFile($records, $file_log_id){

        // счетчики
        $i = 0;
        $step = 0;
        $coeffs = [];


        foreach ($records as $record) {

            $i++;
            var_dump($i);

            if($step == 0){
                DB::beginTransaction();
                echo "beginTransaction\n";

            }

            try {

                $date_from = new \DateTime($record['Дата начала']);
                $date_to = new \DateTime($record['Дата окончания']);


                $obj = Coeff::UpdateOrCreate(
                    ['coeff_type_id' => $record['Тип коэффициента'], 'date_from' => $date_from, 'date_to' => $date_to],
                    ['value' => $record['Процент коэффициента']]
                );

                // dd($obj);

                $coeffs[] = $obj->toArray();

            }catch(Exception $e){
                $this->info($e->getMessage());
                DB::rollBack();
               FileLog::find($file_log_id)->fill(['status'=>2,'description'=>$e->getMessage()])->save();
            }


            if($step == 10){

                DB::commit();
                $step = 0;
                echo "commit\n";
                // ставим замедление
                usleep(50000);

            }else{
                $step++;
            }


        }

        DB::commit();
        return $coeffs;


    }

    public function shopGradeFile($records, $file_log_id){

        // счетчики
        $i = 0;
        $step = 0;
        $shopGrade = [];

        foreach ($records as $record) {

            $search = Shop::firstOrCreate(['name'=>$record['Магазин']]);

            $i++;
//            var_dump($i);

            if($step == 0){
                DB::beginTransaction();
                echo "beginTransaction\n";

            }


            try {


//                $date_from = new \DateTime($record['Дата начала']);
//                $date_to = new \DateTime($record['Дата окончания']);

                $obj = ShopGrades::UpdateOrCreate(
                    ['shop_id' => $search->id, 'date' => $record['Дата'], 'tt_bonus' => $record['Бонус']],
                    ['tt_seperate' => $record['Разбивка']]
                );

                // dd($obj);

                $shopGrade[] = $obj->toArray();

            }catch(Exception $e){
                $this->info($e->getMessage());
                DB::rollBack();
               FileLog::find($file_log_id)->fill(['status'=>2,'description'=>$e->getMessage()])->save();
            }


            if($step == 10){

                DB::commit();
                $step = 0;
                echo "commit\n";
                // ставим замедление
                usleep(50000);

            }else{
                $step++;
            }


        }

        DB::commit();
        return $shopGrade;


    }

    public function _ProductGroupPlan($records, $file_log_id){

        // счетчики
        $i = 0;
        $step = 0;

        // массивы сущностей
        $shops = Shop::all()->toArray();
        $productGroupPlanTypes = ProductGroupPlanType::all()->toArray();
        $productGroups = ProductGroup::all()->toArray();

        $shopRecords = [];
        $productGroupPlanTypeRecords = [];
        $productGroupRecords = [];
        $productGroupPlanRecords = [];
        $productGroupPlans = [];


        foreach ($records as $record) {

            $i++;
            var_dump($i);

            if($step == 0){
                DB::beginTransaction();
                echo "beginTransaction\n";

            }

            try {

                if (isset($shopRecords[$record['Магазин из 1С']])) {
                    $shop_id = $shopRecords[$record['Магазин из 1С']];
                } else {
                    // dd($record['магазин']);
                    $key = array_search($record['Магазин из 1С'], array_column($shops, 'name'));

                    if ($key) {
                        $shopRecords[$record['Магазин из 1С']] = $shops[$key]['id'];
                        $shop_id = $shops[$key]['id'];
                    } else {
                        $shop = Shop::create([
                            'name' => $record['Магазин из 1С'],
                            'mapping_name' => $record['Магазин из 1С'],
                        ])->toArray();

                        $shopRecords[$record['Магазин из 1С']] = $shop['id'];
                        $shop_id = $shop['id'];
                    }
                }

                if (isset($productGroupPlanTypeRecords[$record['тип плана']])) {
                    $product_group_plan_type_id = $productGroupPlanTypeRecords[$record['тип плана']];
                } else {

                    // dd($record['магазин']);
                    $key = array_search($record['тип плана'], array_column($productGroupPlanTypes, 'name'));

                    if ($key) {
                        $productGroupPlanTypeRecords[$record['тип плана']] = $productGroupPlanTypes[$key]['id'];
                        $product_group_plan_type_id = $productGroupPlanTypes[$key]['id'];
                    } else {
                        $productGroupPlanType = ProductGroupPlanType::create([
                            'name' => $record['тип плана'],
                            'description' => $record['тип плана'],
                        ])->toArray();

                        $productGroupPlanTypeRecords[$record['тип плана']] = $productGroupPlanType['id'];
                        $product_group_plan_type_id = $productGroupPlanType['id'];
                    }
                }


                if (isset($productGroupRecords[$record['Группа по планам']])) {
                    $product_group_id = $productGroupRecords[$record['Группа по планам']];
                } else {
                    $key = array_search($record['Группа по планам'], array_column($productGroups, 'name'));
                    if ($key) {
                        $productGroupRecords[$record['Группа по планам']] = $productGroups[$key]['id'];
                        $product_group_id = $productGroups[$key]['id'];
                    } else {
                        $product_group = ProductGroup::create([
                            'name' => $record['Группа по планам'],
                            'description' => $record['Группа по планам']
                        ])->toArray();
                        $productGroupRecords[$record['Группа по планам']] = $product_group['id'];
                        $product_group_id = $product_group['id'];
                    }
                }


                $date_from = new \DateTime($record['дата начала действия']);
                $date_to = new \DateTime($record['дата окончания действия']);

                if (!empty($shop_id) && !empty($product_group_id) && !empty($product_group_plan_type_id)) {

                    $obj = ProductGroupPlan::UpdateOrCreate(
                        ['product_group_id' => $product_group_id, 'shop_id' => $shop_id, 'date_from' => $date_from, 'date_to' => $date_to],
                        ['product_group_plan_type_id' => $product_group_plan_type_id, 'value' => $record['План на месяц, руб']]
                    );

                    $productGroupPlans[] = $obj->toArray();
                }

            }catch(Exception $e){
                $this->info($e->getMessage());
                DB::rollBack();
               FileLog::find($file_log_id)->fill(['status'=>2,'description'=>$e->getMessage()])->save();
            }

            //dd($obj);

            if($step == 10){

                DB::commit();
                $step = 0;
                echo "commit\n";
                // ставим замедление
                usleep(50000);

            }else{
                $step++;
            }
        }

        DB::commit();
        return $productGroupPlans;

    }





    // запись в ProductGroupPlan
    public function ProductGroupPlan($records){

        // dd('--- ProductGroupPlan ---');

        // массивы сущностей
        $shops = [];
        $productGroupPlanTypes = [];
        $productGroups = [];

        $productGroupPlans = [];


        foreach ($records as $record) {




            // dd($record);
            $shop_id = false;
            $product_group_id = false;
            $product_group_plan_type_id = false;

            $date_from = date_format(date_create($record['дата начала действия']),"Y-m-d H:i:s");
            $date_to = date_format(date_create($record['дата окончания действия']),"Y-m-d H:i:s");

            // dd($record);
            // dd($date_from);
            // dd($date_to);


            if(isset($shops[$record['Магазин из 1С']])){
                $shop_id = $shops[$record['Магазин из 1С']];
            }
            else{

                if($shop = Shop::where('name', $record['Магазин из 1С'])->first()){
                    $shop_id = $shop->toArray()['id'];
                }else{
                    $shop_id = Shop::create([
                        'name'=>$record['Магазин из 1С']
                    ])->toArray()['id'];

                }
            }

            // dd($shop_id);


            if(isset($productGroupPlanTypes[$record['тип плана']])){
                $product_group_plan_type_id = $productGroupPlanTypes[$record['тип плана']];

            }else{

                if($productGroupPlanType = ProductGroupPlanType::where('name', $record['тип плана'])->first()){
                    $product_group_plan_type_id = $productGroupPlanType->toArray()['id'];
                }else{
                    $product_group_plan_type_id = ProductGroupPlanType::create([
                        'name'=>$record['тип плана'],
                        'description'=>$record['тип плана']
                    ])->toArray()['id'];
                }

            }

            // dd($product_group_plan_type_id);

            if(isset($productGroups[$record['Группа по планам']])){
                $product_group_id  = $productGroups[$record['Группа по планам']];
            }
            else{

                if($product_group = ProductGroup::where('name', $record['Группа по планам'])->first()){
                    $product_group_id = $product_group->toArray()['id'];
                }else{

                    $product_group_id = ProductGroup::create([
                        'name'=>$record['Группа по планам'],
                        'description'=>$record['Группа по планам']
                    ])->toArray()['id'];

                    // dd($product_group_id);
                }
                $shops[$record['Группа по планам']] = $product_group_id;
            }

            // dd($product_group_id);





            if(!empty($shop_id) && !empty($product_group_id) && !empty($product_group_plan_type_id)){

//                $obj = ProductGroupPlan::create([
//                    'product_group_plan_type_id' =>$product_group_plan_type_id,
//                    'product_group'=>$product_group,
//                    'shop_id'=>$shop_id,
//                    'date_from'=>$date_from,
//                    'date_to'=>$date_to,
//                    'value'=>$record['План на месяц, руб']
//                ]);


                $obj = ProductGroupPlan::UpdateOrCreate(
                    [
                        'product_group'=>$product_group, //
                        'shop_id'=>$shop_id, //
                        'date_from'=>$date_from,//
                        'date_to'=>$date_to,//
                    ],
                    [
                        'product_group_plan_type_id' =>$product_group_plan_type_id,
                        'value'=>$record['План на месяц, руб']
                    ]);

                //dd($obj->toArray());
                $productGroupPlans[] = $obj->toArray();

                // dd()
            }

        }

        return $productGroupPlans;
    }





}