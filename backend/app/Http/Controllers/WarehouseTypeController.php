<?php

namespace App\Http\Controllers;

use App\Http\Requests\WarehouseTypeFormData;
use Illuminate\Http\Request;
use App\WarehouseType;

class WarehouseTypeController extends Controller
{

    protected $model;

    public function __construct()
    {
        $this->model = WarehouseType::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warehouseTypes = WarehouseType::all();
        if($warehouseTypes->count()){
            return response($warehouseTypes);
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
    public function store(WarehouseTypeFormData $request)
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
        $warehouseType = WarehouseType::find($id);
        if($warehouseType){
            return response($warehouseType);
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
    public function update(WarehouseTypeFormData $request, $id)
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
        $warehouseType = WarehouseType::find($id);
        if($warehouseType){
            $warehouseType->delete();
            return response()->json($warehouseType, 201);

        }else{
            return response()->json(['message'=>'не удалось удалить запись'],404);

        }
    }
}
