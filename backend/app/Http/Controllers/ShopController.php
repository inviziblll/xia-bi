<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopFormData;
use Illuminate\Http\Request;
use App\Shop;

class ShopController extends Controller
{

    protected $model;

    public function __construct()
    {
        $this->model = Shop::class;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shops = Shop::all();
        if($shops->count()){
            return response($shops);
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
    public function store(ShopFormData $request)
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
        $shop = Shop::find($id);
        if($shop){
            return response($shop);
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
    public function update(ShopFormData $request, $id)
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
        $shop = Shop::find($id);
        if($shop){
            $shop->delete();
            return response()->json($shop, 201);

        }else{
            return response()->json(['message'=>'не удалось удалить запись'],404);

        }
    }


}
