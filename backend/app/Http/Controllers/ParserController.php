<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpImap\Mailbox;
use App\VisitLog;
use App\Shop;
use App\FileLog;
use League\Csv\Reader;
use League\Csv\Statement;

class ParserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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

        //dd($attachments);

        foreach ($attachments as $item){
            $file = new \SplFileInfo($item->filePath);
            dd($file);

            if($file->getExtension() == 'csv'){

                $filelog = FileLog::create(['file_name' => $file->getFilename(), 'path'=> $file->getPath(),'status'=> 1]);
                $this->readCSV($item->filePath);

            }

        }
    }






    public function readCSV($csv_file){
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

            $log = Shop::where('mapping_name', $record['Название'])->first()->visitlogs()->create([
                'count' => $record['Количество посетителей'],
                'date'=> substr($record['Дата'], 0, -8)
            ]);

            // dd($log);
            // print_r($log->toArray());

        }
    }

    public function _readCSV($csv_file){

        $handle = fopen($csv_file, "r"); //Открываем csv для чтения
        $i = 0;

        //Проходим весь csv-файл, и читаем построчно. 3-ий параметр разделитель поля
        while (($line = fgetcsv($handle, 0, ";")) !== FALSE) {

            if($i>0){

                try {
                    $shop = Shop::where('mapping_name', $line[0])->first();
                    $log = VisitLog::create(['count' => $line[5], 'shop_id'=> $shop['id'],'date'=> substr($line[2], 0, -8)]);
                    // print_r($log->toArray());
                }
                catch (\Exception $e) {
                    // return $e->getMessage();
                    print_r($e->getMessage());
                }

                // if($i>20000){
                //     die();
                // }

            }
            $i++;
        }

    }

    public function getCSV($csv_file){
        $handle = fopen($csv_file, "r"); //Открываем csv для чтения
        $array_line_full = array(); //Массив будет хранить данные из csv

        //Проходим весь csv-файл, и читаем построчно. 3-ий параметр разделитель поля
        while (($line = fgetcsv($handle, 0, ";")) !== FALSE) {
            $array_line_full[] = $line; //Записываем строчки в массив
        }

        fclose($handle); //Закрываем файл
        unset($array_line_full[0]); // удаляем заголовок

        // unset($array_line_full[1]);
        return $array_line_full; //Возвращаем прочтенные данные
    }


    public function basepath(){
        $path = base_path().'/storage/upload';

        // dd($path);
        // return response($path);
        return __DIR__;
    }

    public function testLog(){

        //  2018-02-01 00:00 - 00:59
        $str = '2018-02-01 00:00 - 00:59';
        $log = VisitLog::create(['count' => 0,'date'=> substr($str, 0, -8)]);
        return response($log);
    }


    public function setData($csv){
        foreach($csv as $item){
            // $log = VisitLog::create(['count' => $item[5], 'date'=> substr($item[2], 0, -8)]);
            $shop = Shop::where('mapping_name', $item[0] )->first();
            // dd($shop['id']);

            if($shop['id']){
                $log = VisitLog::create(['count' => $item[5], 'shop_id'=> $shop['id'],'date'=> substr($item[2], 0, -8)]);
            }

            var_dump($log->toArray());
            // die();
        }
    }
}
