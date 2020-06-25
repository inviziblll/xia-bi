<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductGroupPlanTypeFormData;
use Illuminate\Http\Request;
use App\ProductGroupPlanType;



class ProductGroupPlanTypeController extends Controller
{

    protected $model;

    public function __construct()
    {
        $this->model = ProductGroupPlanType::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productGroupPlanTypes = ProductGroupPlanType::all();
        if($productGroupPlanTypes->count()){
            return response($productGroupPlanTypes);
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
    public function store(ProductGroupPlanTypeFormData $request)
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
        $productGroupPlanType  = ProductGroupPlanType::find($id);
        if($productGroupPlanType){
            return response($productGroupPlanType);
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
    public function update(ProductGroupPlanTypeFormData $request, $id)
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
        $productGroupPlanType  = ProductGroupPlanType::find($id);
        if($productGroupPlanType){
            $productGroupPlanType->delete();
            return response()->json($productGroupPlanType, 201);

        }else{
            return response()->json(['message'=>'не удалось удалить запись'],404);

        }
    }


}
