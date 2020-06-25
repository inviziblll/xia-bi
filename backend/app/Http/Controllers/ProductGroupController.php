<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductGroupFormData; // класс валидации полей при создании новой записи
use Illuminate\Http\Request;
use App\ProductGroup; // модель пользователь

class ProductGroupController extends Controller
{

    protected $model;

    public function __construct()
    {
        $this->model = ProductGroup::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $productGroups = ProductGroup::all();

        if($productGroups->count()){
            return response($productGroups);
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
    public function store(ProductGroupFormData $request)
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
        $productGroup  = ProductGroup::find($id);
        if($productGroup){
            return response($productGroup);
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
    public function update(ProductGroupFormData $request, $id)
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
        $productGroup  = ProductGroup::find($id);

        if($productGroup){
            $productGroup->delete();
            return response()->json($productGroup, 201);

        }else{
            return response()->json(['message'=>'не удалось удалить запись'],404);

        }
    }


}
