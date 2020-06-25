<?php

namespace App\Http\Controllers;


use App\Http\Requests\FileTypeFormData;
use Illuminate\Http\Request;
use App\FileType;


class FileTypeController extends Controller
{

    protected $model;

    public function __construct()
    {
        $this->model = FileType::class;
    }
 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fileType = FileType::all();

        if($fileType->count()){
            return response($fileType);
        }else{
            return response()->json(['message'=>'записей нет'], 404);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FileTypeFormData $request)
    {
        return response($this->set_model($id = null, $model = $this->model, $request));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fileType = FileType::find($id);
        if($fileType){
            return response($fileType);
        }else{
            return response()->json(['message'=>'запись не найдена'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FileTypeFormData $request, $id)
    {
        return response($this->set_model($id, $model = $this->model, $request));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fileType = FileType::find($id);
        if($fileType){
            $fileType->delete();
            return response()->json($fileType, 201);

        }else{
            return response()->json(['message'=>'не удалось удалить запись'],404);

        }
    }
}
