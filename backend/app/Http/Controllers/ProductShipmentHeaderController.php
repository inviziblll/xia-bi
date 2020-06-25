<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductShipmentHeaderFormData;
use Illuminate\Http\Request;
use App\ProductShipmentHeader; 

class ProductShipmentHeaderController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = ProductShipmentHeader::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productShipmentHeaders = ProductShipmentHeader::paginate(100);
        if($productShipmentHeaders->count()){
            return response($productShipmentHeaders);
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
    public function store(ProductShipmentHeaderFormData $request)
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
        $productShipmentHeader = ProductShipmentHeader::find($id);
        if($productShipmentHeader){
            return response($productShipmentHeader);
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
    public function update(ProductShipmentHeaderFormData $request, $id)
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
        $productShipmentHeader = ProductShipmentHeader::find($id);
        if($productShipmentHeader){
            $productShipmentHeader->delete();
            return response()->json($productShipmentHeader, 201);

        }else{
            return response()->json(['message'=>'не удалось удалить запись'],404);

        }
    }
}
