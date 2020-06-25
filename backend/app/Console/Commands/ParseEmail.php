<?php
/**
 * Created by IntelliJ IDEA.
 * User: alexburov
 * Date: 26.04.18
 * Time: 16:05
 */

namespace App\Console\Commands;


use App\FileStatus;
use Illuminate\Console\Command;

use Illuminate\Support\Facades\File;

use App\Shop;
use App\FileLog;
use App\FileType;

use League\Csv\Reader;
use League\Csv\Statement;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ParseEmail  extends Command
{
    /**
     * Имя и аргументы консольной команды.
     *
     * @var string
     */
    protected $signature = 'cron:parseemail';

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

        //\Log::info('Test - '.\Carbon\Carbon::now());
    }

    /** чтение файлов **/
    public function file_reader(){

          // echo "file_reader <br/>";

                    $file_status_id = FileStatus::with('fileLogs')->where(['code'=>'Ready'])->first()->id;


                    $fileLogs = FileLog::where(['file_status_id'=>$file_status_id])->get();

                    foreach ($fileLogs as $item){

                        $fileType =  substr($item->file_name, strpos($item->file_name, '.', -4));

                        // обновляем данные
                        if($item->file_type_id == 2 && $fileType == '.csv'){
                            FileLog::find($item->id)->fill(['file_status_id'=>$file_status_id])->save();
                            // читаем CSV файл
                            $this->read_csv(base_path().'/'.$item->path);
                        }
                    }

        // return $fileLogs;
    }


    public function read_csv($csv_file){

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
        foreach ($records as $record) {

            // записи в  модель VisitLog
            $log = Shop::where('mapping_name', $record['Название'])->first()->visitlogs()->create([
                'count' => $record['Количество посетителей'],
                'date'=> substr($record['Дата'], 0, -8)
            ]);
            // dd($log);
            // print_r($log->toArray());

        }
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




}