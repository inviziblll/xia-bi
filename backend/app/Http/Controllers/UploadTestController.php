<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use League\Csv\Reader;
use League\Csv\Statement;

use Illuminate\Support\Facades\Validator;

use App\FileLog;
use App\VisitLog;
use App\StaffPlan;
use App\Shop;
use App\User;
use App\Shift;
use App\ProductGroup;
use App\ProductGroupPlan;
use App\ProductGroupPlanType;

class UploadTestController extends Controller
{
    // загрузка файлов
    public function index(Request $request)
    {
        $rules = array(
            'file'=> 'required|max:30000',
            'file_type_id'=>'required|integer'
        );
        $validator = Validator::make($request->toArray(), $rules);

        if($validator->fails()) {
            return response()->json([
                'message'=>'Вы не заполнили нужные поля',
            ], 200);

        }

        $file = $request->file('file');
        $file_type_id = $request->file_type_id;

        //dd($file);

        if($file){
            $basenamefile = $file->getClientOriginalName();
            $extends = substr($basenamefile, strpos($basenamefile, '.', -5));

            if($extends == '.csv'){
                // сохраняем файл и записываем данные в таблицу
                $file_name = md5($basenamefile).$extends;
                $csv_file =  $file->storeAs('upload', $file_name);
                $file_path = 'storage/app/'.$csv_file;

                // dd($file_path);

                $fileLog = FileLog::create([
                    'file_name' => $file_name,
                    'original_file_name'=>$basenamefile,
                    'path'=> $file_path,
                    'file_type_id'=>$file_type_id,
                    'status'=>0,

                ]);
                return $fileLog;
            }
            else{
                return response()->json(['message'=>'не верный формат файла'], 200);
            }
        }

    }


    public function emailreader()
    {
        $server = "{imap.yandex.ru:993/imap/ssl}";
        $login = 'xiaomi@webinnovations.ru';
        $password = 'xiaomi123@';

        // $mailbox = new Mailbox($server, $login , $password, __DIR__);
        // var_dump($mailbox->getListingFolders());


        $mailbox = new Mailbox($server, $login , $password, base_path().'/storage/upload');

        // read all messaged into an array
        $mailsIds = $mailbox->searchMailbox('UNSEEN');
        if(!$mailsIds) {
            die('Mailbox is empty');
        }
        $mail = $mailbox->getMail($mailsIds[0]);
        $attachments = $mail->getAttachments();

        foreach ($attachments as $item){
            $file = new \SplFileInfo($item->filePath);

            if($file->getExtension() == 'csv'){

                // $filelog = FileLog::create(['file_name' => $file->getFilename(), 'path'=> $file->getPath(),'status'=> 1]);
                $this->readCSV($item->filePath);

            }

        }
    }


    // чтение файлов
    public function reader(Request $request){

        // $fileLogs = FileLog::where('status', '0')->get();
        // dd($request->name);

        $fileLog = FileLog::where('status', $request->status)->where('file_name', $request->name)->first();
        // dd($fileLog);

        // обновляем данные
        // FileLog::find($fileLog->id)->fill(['status'=>1])->save();
        // dd($fileLog->path);

        // читаем CSV файл
        $result = $this->csvReader(base_path().'/'.$fileLog->path, $fileLog->file_type_id);

        return $result;
    }




    // читаем CSV документ
    public function csvReader($csv_file, $file_type_id){

        //dd($csv_file);


        //load the CSV document from a stream
        $stream = fopen($csv_file, 'r');
        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        //build a statement
        $stmt = (new Statement())
            ->offset(10)
            ->limit(25);

        //query your records from the document
        $records = $stmt->process($csv);
        $result = false;


//         foreach ($records as $record){
//                    echo '<pre>';
//                    var_dump($record);
//                    echo '<pre>';
//         }
//
//
//        dd('----');
        // dd($file_type_id);

        if($file_type_id == 2 || $file_type_id == 1){
            $result = $this->writeVisitlog($records);
        }

        if($file_type_id == 3){
            $result  = $this->writeShopShift($records);
        }

        if($file_type_id == 4){
            $result = $this->ProductGroupPlan($records);
        }

        return $result;

    }


    // запись в Visitlog
    public function writeVisitlog($records){

        // dd('--- writeVisitlog ---');


        $logs = [];

        foreach ($records as $record) {
            // записи в  модель VisitLog
            $obj = Shop::where('mapping_name', $record['Название'])->first()->visitlogs()->create([
                'count' => $record['Количество посетителей'],
                'date' => substr($record['Дата'], 0, -8)
            ]);

            $logs[] = $obj->toArray();

        }

        return $logs;
    }

    // запись в ShopShift
    public function writeShopShift($records)
    {

        // массивы сущностей
        $shops = [];
        $users = [];
        $shifts = [];
        $shop_shifts = [];


        foreach ($records as $record) {
            $user_id = 0;
            $shift_id = 0;

            if(isset($shops[$record['магазин']])){
                $shop_id = $shops[$record['магазин']];
            }
            else{
                $shop_id = Shop::where('name', $record['магазин'])->first()->toArray()['id'];
                $shops[$record['магазин']] = $shop_id;
            }

            if(isset($users[$record['ФИО продавца']])){
                $user_id = $users[$record['ФИО продавца']];
            }
            else{
                if($user = User::where('name', $record['ФИО продавца'])->first()){
                    $user_id = $user->toArray()['id'];
                    $users[$record['ФИО продавца']] = $user_id;
                }
            }


            if(isset($shifts[$record['Смена']])){
                $shift_id = $shifts[$record['Смена']];
            }
            else{
                //$shift_id = '';
                if($shift = Shift::where('name', $record['Смена'])->first()){
                    $shift_id = $shift->toArray()['id'];
                    $shifts[$record['Смена']] = $shift_id;
                }
            }


            if($user_id){
                $date = date_format(date_create($record['День']),"Y-m-d H:i:s");
                $shopShift = StaffPlan::create([
                    'shop_id' => $shop_id,
                    'user_id'=> $user_id,
                    'role_id'=> 1,
                    'shift_id'=> $shift_id,
                    'date'=> $date
                ]);

                $shop_shifts[] = $shopShift->toArray();
            }

        }

        return $shop_shifts;

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


            if(isset($shops[$record['Магазин из 1С']])){
                $shop_id = $shops[$record['Магазин из 1С']];
            }
            else{

                if($shop = Shop::where('name', $record['Магазин из 1С'])->first()){
                    $shop_id = $shop->toArray()['id'];
                }else{
                    $shop_id = Shop::create([
                        'name'=>$record['Магазин из 1С']
                    ]);
                }
            }


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

            $date_from = date_format(date_create($record['дата начала действия']),"Y-m-d H:i:s");
            $date_to = date_format(date_create($record['дата окончания действия']),"Y-m-d H:i:s");


            if(!empty($shop_id) && !empty($product_group_id) && !empty($product_group_plan_type_id)){

                $obj = ProductGroupPlan::create([
                    'product_group_plan_type_id' =>$product_group_plan_type_id,
                    'product_group'=>$product_group,
                    'shop_id'=>$shop_id,
                    'date_from'=>$date_from,
                    'date_to'=>$date_to,
                    'value'=>$record['План на месяц, руб']
                ]);

                // dd($obj->toArray());
                $productGroupPlans[] = $obj->toArray();
            }

        }

        return $productGroupPlans;
    }


    // для CRON
    public function file_reader(){

        // dd('---');

        echo "file_reader start <br/>";

        $fileLogs = FileLog::where('status', '0')->get();

        foreach ($fileLogs as $item){

            $fileType =  substr($item->file_name, strpos($item->file_name, '.', -4));

            // обновляем данные
            FileLog::find($item->id)->fill(['status'=>1])->save();

            // читаем CSV файл
            $this->csvReader(base_path().'/'.$item->path, $item->file_type_id);
        }

        // return $fileLogs;
        echo "file_reader and <br/>";
    }



}
