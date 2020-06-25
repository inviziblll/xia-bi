<?php
/**
 * Created by IntelliJ IDEA.
 * User: peyagodson
 * Date: 17.05.2018
 * Time: 12:07
 */

namespace App\Http\FilesReader;


use Illuminate\Database\Eloquent\Model;
use League\Csv\Reader;

trait FileMethods
{


    /**
     * @param $file
     * @param $file_type
     * @throws \League\Csv\Exception
     */
//    public function __construct()
//    {
//
//    }

    public function csvReader($file, $file_type){

        $dateStart = date("Y-m-d H:i:s");

        FileLogCopy::where('status', '0')->update(['status' => 1]);
        $fileLogs = FileLogCopy::where('status', '1')->where('updated_at', '>', $dateStart)->get();
        $result = [];

        foreach ($fileLogs as $item) {
            echo 'start foreach \n';

            $fileType = substr($item->file_name, strpos($item->file_name, '.', -4));

            // читаем CSV файл
        }


        $stream = fopen($file, 'r');
        $csv = Reader::createFromStream($stream);

        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        //build a statement
        $stmt = new Statement();
        $stmt->offset(10)->limit(25);

        $records = $stmt->process($csv);
        $result = false;
    }


    /**
     * @param Model $model
     * @param array $data
     */
    public function saveToBD(Model $model, $data=array()){

    }



}