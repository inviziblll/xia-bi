<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductTypeFormData;
use Illuminate\Http\Request;
use App\ProductType;

class ProductTypeController extends Controller
{

    protected $model;

    public function __construct()
    {
        $this->model = ProductType::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productTypes = ProductType::all();
        if($productTypes->count()){
            return response($productTypes);
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
    public function store(ProductTypeFormData $request)
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
        $productType  = ProductType::find($id);
        if($productType){
            return response($productType);
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
    public function update(ProductTypeFormData $request, $id)
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
        $productType  = ProductType::find($id);
        if($productType){
            $productType->delete();
            return response()->json($productType, 201);

        }else{
            return response()->json(['message'=>'не удалось удалить запись'],404);

        }
    }
}
