<?php

namespace App\Http\Controllers;

use App\Http\Requests\CoeffTypeFormData;
use Illuminate\Http\Request;
use App\CoeffType;


class CoeffTypeController extends Controller
{

    protected $model;

    public function __construct()
    {
        $this->model = CoeffType::class;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coeffTypes = CoeffType::all();

        // dd($coeffTypes);
        if($coeffTypes->count()){
            return response($coeffTypes);
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
    public function store(CoeffTypeFormData $request)
    {
         //dd($request);
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
        $coeffType = CoeffType::find($id);
        if($coeffType){
            return response($coeffType);
        }else{
            return response()->json(['message'=>'запись не найдена'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CoeffTypeFormData $request, $id)
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
        $coeffType = CoeffType::find($id);
        if($coeffType){
            $coeffType->delete();
            return response()->json($coeffType, 201);

        }else{
            return response()->json(['message'=>'не удалось удалить запись'],404);

        }
    }
}
