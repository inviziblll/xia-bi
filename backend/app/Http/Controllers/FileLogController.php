<?php

namespace App\Http\Controllers;

use App\FileStatus;
use Illuminate\Http\Request;
use App\Shop;
use App\FileLog;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\Statement;
use Illuminate\Support\Facades\Validator;

class FileLogController extends Controller
{

    protected $model;
    public function __construct()
    {
        $this->model = FileLog::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $fileLog = FileLog::with(["fileStatus","fileType"])->exclude('content')->paginate(100);
        if($fileLog->count()){
            return response($fileLog);
        }else{
            return response()->json(['message'=>'записей нет'], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

        $file_status_id = FileStatus::with('fileLogs')->where(['code'=>'Ready'])->first()->id;


        $file = $request->file('file');
        $content = file_get_contents($file);
        $file_type_id = $request->file_type_id;

        if($file){
            $basenamefile = $file->getClientOriginalName();
            $extends = substr($basenamefile, strpos($basenamefile, '.', -5));

            if($extends == '.csv'){

                // сохраняем файл и записываем данные в таблицу
                $file_name = md5($basenamefile).$extends;
                $csv_file =  $file->storeAs('upload', $file_name);

                $file_path = 'storage/app/'.$csv_file;
                $upload_date = date("Y-m-d H:i:s");

                $fileLog =FileLog::create([
                    'file_name' => $basenamefile,
                    'original_file_name'=>$basenamefile,
                    'path'=> $file_path,
                    'file_type_id'=>$file_type_id,
                    'upload_date'=>$upload_date,
                    'file_status_id'=>$file_status_id,
                    'content'=>$content
                ]);


                return FileLog::with(["fileStatus","fileType"])->find($fileLog->id);
            }
            else{
                return response()->json(['message'=>'не верный формат файла'], 200);
            }
        }

    }



    public function store_old(Request $request)
    {

        $rules = array('file'=> 'required|max:30000');
        $validator = Validator::make($request->toArray(), $rules);

        if($validator->fails()) {
            return response()->json([
                'message'=>'Вы не заполнили поле "Файл"',
            ], 200);
        }

        $file = $request->file('file');
        if($file){
            $basenamefile = $file->getClientOriginalName();
            $extends = substr($basenamefile, strpos($basenamefile, '.', -5));
            $csv_file =  $file->storeAs('upload', md5($basenamefile).$extends);

            if($extends == '.csv'){
                $this->readCSV_old($csv_file);
            }

            return response()->json([
                'message'=>'Вы отправили документ '.$basenamefile.' на чтение',
            ], 200);

        }

    }



    public function  upload_old(Request $request)
    {

        $path = base_path().'/storage/upload';
        $file = $request->file('file');
        if($file){

            $basenamefile = $file->getClientOriginalName();
            dd($basenamefile);
            $hash_file = md5_file($file);
            $extends = substr($basenamefile, strpos($basenamefile, '.', -5));
            // dd($hash_file);
            // dd($extends);
            $file->storeAs($path, md5($basenamefile).$extends);
            // dd($extends);

        }

    }

    public function readCSV_old($csv_file){
        //load the CSV document from a stream
        $stream = fopen(base_path().'/storage/app/'.$csv_file, 'r');
        $csv = Reader::createFromStream($stream);
        try{
            $csv->setDelimiter(';');
            $csv->setHeaderOffset(0);
        }catch (Exception $ex){
            echo $ex->getMessage();
        }
        try {
            //build a statement
            $stmt = (new Statement())
                ->offset(10)
                ->limit(25);
        }catch (Exception $ex){
            echo $ex->getMessage();
        }
        //query your records from the document
        $records = $stmt->process($csv);
        foreach ($records as $record) {

            // записи в  модель VisitLog
            $log = Shop::where('mapping_name', $record['Название'])->first()->visitlogs()->create([
                'count' => $record['Количество посетителей'],
                'date'=> substr($record['Дата'], 0, -8)
            ]);

            // dd($log);
            print_r($log->toArray());

        }
    }






    /**** в крон ****/

    public function read_csv($csv_file){

        //load the CSV document from a stream
        $stream = fopen($csv_file, 'r');
        $csv = Reader::createFromStream($stream);

        try{

            $csv->setDelimiter(';');
            $csv->setHeaderOffset(0);

        }catch (Exception $ex){
            echo $ex->getMessage();
        }
        //build a statement
        try{
            $stmt = (new Statement())->offset(10)->limit(25);
        }catch (Exception $ex){
            echo $ex->getMessage();
        }


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

    public function upload(Request $request){

        $rules = array('file'=> 'required|max:30000');
        $validator = Validator::make($request->toArray(), $rules);
        if($validator->fails()) {
            return response()->json([
                'message'=>'Вы не заполнили поле "Файл"',
            ], 200);
        }
        $file = $request->file('file');
        // dd($file );


        if($file){
            $basenamefile = $file->getClientOriginalName();
            $extends = substr($basenamefile, strpos($basenamefile, '.', -5));

            if($extends == '.csv'){

                // сохраняем файл и записываем данные в таблицу
                $file_name = md5($basenamefile).$extends;
                $csv_file =  $file->storeAs('upload', $file_name);
                $file_path = 'storage/app/'.$csv_file;
                $fileLog = FileType::where('name', 'Посещение')->first()->fileLogs()->create([
                    'file_name' => $basenamefile,
                    'path'=> $file_path,
                    'status'=>0
                ]);

                // dd($fileLog);

                return $fileLog;
            }
        }
    }



    public function directory (Request $request){

        $directory = base_path().'/storage/upload';
        $files = Storage::files($directory);

        foreach ($files as $file){
            dd($file);
        }
        return $files;

    }

    public function file_reader(){

        $fileLogs =FileLog::where('status', '0')->get();

        foreach ($fileLogs as $item){

            $fileType =  substr($item->file_name, strpos($item->file_name, '.', -4));

            // обновляем данные
            if($item->file_type_id == 2 && $fileType == '.csv'){

                FileLog::find($item->id)->fill(['status'=>1])->save();

                // читаем CSV файл
                $this->read_csv(base_path().'/'.$item->path);
            }
        }

        // return $fileLogs;
    }
}
