<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductShipmentDetailFormData;
use Illuminate\Http\Request;
use App\ProductShipmentDetail; 

class ProductShipmentDetailController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = ProductShipmentDetail::class;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productShipmentDetails = ProductShipmentDetail::paginate(100);
        if($productShipmentDetails->count()){
            return response($productShipmentDetails);
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
    public function store(ProductShipmentDetailFormData $request)
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
        $productShipmentDetail = ProductShipmentDetail::find($id);
        if($productShipmentDetail){
            return response($productShipmentDetail);
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
    public function update(ProductShipmentDetailFormData $request, $id)
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
        $productShipmentDetail = ProductShipmentDetail::find($id);
        if($productShipmentDetail){
            $productShipmentDetail->delete();
            return response()->json($productShipmentDetail, 201);

        }else{
            return response()->json(['message'=>'не удалось удалить запись'],404);

        }

    }
}
