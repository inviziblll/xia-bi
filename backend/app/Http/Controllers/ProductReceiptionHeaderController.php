<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductReceiptionHeaderFormData;
use Illuminate\Http\Request;
use App\ProductReceiptionHeader; 


class ProductReceiptionHeaderController extends Controller
{

    protected $model;

    public function __construct()
    {
        $this->model = ProductReceiptionHeader::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productReceiptionHeaders = ProductReceiptionHeader::paginate(100);
        if($productReceiptionHeaders->count()){
            return response($productReceiptionHeaders);
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
    public function store(ProductReceiptionHeaderFormData $request)
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
        $productReceiptionHeader = ProductReceiptionHeader::find($id);
        if($productReceiptionHeader){
            return response($productReceiptionHeader);
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
    public function update(ProductReceiptionHeaderFormData $request, $id)
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
        $productReceiptionHeader = ProductReceiptionHeader::find($id);
        if($productReceiptionHeader){
            $productReceiptionHeader->delete();
            return response()->json($productReceiptionHeader, 201);

        }else{
            return response()->json(['message'=>'не удалось удалить запись'],404);

        }        
    }
}
