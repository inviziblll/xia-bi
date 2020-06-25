<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopTypeFormData;
use Illuminate\Http\Request; 
use App\ShopType;


class ShopTypeController extends Controller
{

    protected $model;

    public function __construct()
    {
        $this->model = ShopType::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shoptypes = ShopType::all();

        if($shoptypes->count()){
            return response($shoptypes);
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
    public function store(ShopTypeFormData $request)
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
        $shoptype  = ShopType::find($id);
        if($shoptype){
            return response($shoptype);
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
    public function update(ShopTypeFormData $request, $id)
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
        $shoptype  = ShopType::find($id);
        if($shoptype){
            $shoptype->delete();
            return response()->json($shoptype, 201);

        }else{
            return response()->json(['message'=>'не удалось удалить запись'],404);

        }
    }
}
