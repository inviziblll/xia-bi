<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeasureTypeFormData;
use Illuminate\Http\Request;
use App\MeasureType;

class MeasureTypeController extends Controller
{

    protected $model;

    public function __construct()
    {
        $this->model = MeasureType::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $measureTypes = MeasureType::all();
        if($measureTypes->count()){
            return response($measureTypes);
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
    public function store(MeasureTypeFormData $request)
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
        $measureType  = MeasureType::find($id);
        if($measureType){
            return response($measureType);
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
    public function update(MeasureTypeFormData $request, $id)
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
        $measureType  = MeasureType::find($id);
        if($measureType){
            $measureType->delete();
            return response()->json($measureType, 201);

        }else{
            return response()->json(['message'=>'не удалось удалить запись'],404);

        }
    }

}
