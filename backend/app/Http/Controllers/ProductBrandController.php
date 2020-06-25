<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductBrandFormData;
use Illuminate\Http\Request;
use App\ProductBrand;

class ProductBrandController extends Controller
{

    protected $model;

    public function __construct()
    {
        $this->model = ProductBrand::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productBrands = ProductBrand::all();
        if($productBrands ->count()){
            return response($productBrands);
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
    public function store(ProductBrandFormData $request)
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
        $productBrand = ProductBrand::find($id);
        if($productBrand){
            return response($productBrand);
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
    public function update(ProductBrandFormData $request, $id)
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
        $productBrand = ProductBrand::find($id);

        if($productBrand){
            $productBrand->delete();
            return response()->json($productBrand, 201);

        }else{
            return response()->json(['message'=>'не удалось удалить запись'],404);
        }

    }


}
