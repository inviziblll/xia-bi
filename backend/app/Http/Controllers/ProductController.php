<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductFormData;
use App\ProductGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Product;

class ProductController extends Controller
{

    protected $model;

    public function __construct()
    {
        $this->model = Product::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with("groups")->get();

        if($products->count()){
            return response($products);
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
    public function store(ProductFormData $request)
    {
//        Product::with()->updateOrCreate()
        $product = Product::firstOrCreate(['sku'=>$request->get('sku')],$request->all());

        $product->groups()->sync(array_map(function($item){
            return $item['id'];
        }, $request->get('groups')));

        $createdProd = $product::with("groups")->find($product->id);

        return response($createdProd);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with(["groups"])->find($id);

        if($product){
            return response($product);
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
    public function update(ProductFormData $request, $id)
    {
        $product = Product::updateOrCreate(['id'=>$id],$request->all());

        $product->groups()->sync(array_map(function($item){
            return $item['id'];
        }, $request->get('groups')));

        $createdProd = $product::with("groups")->find($id);

        return response($createdProd);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::with("groups")->find($id);

        if($product){

            $product->delete();

            return response()->json($product, 201);

        }else{
            return response()->json(['message'=>'не удалось удалить запись'],404);

        }
    }


}
