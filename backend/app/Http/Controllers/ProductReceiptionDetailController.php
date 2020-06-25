<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductReceiptionDetailFormData;
use Illuminate\Http\Request;
use App\ProductReceiptionDetail; 

class ProductReceiptionDetailController extends Controller
{

    protected $model;

    public function __construct()
    {
        $this->model = ProductReceiptionDetail::class;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productReceiptionDetails = ProductReceiptionDetail::paginate(100);
        if($productReceiptionDetails->count()){
            return response($productReceiptionDetails);
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
    public function store(ProductReceiptionDetailFormData $request)
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
        $productReceiptionDetail = ProductReceiptionDetail::find($id);
        if($productReceiptionDetail){
            return response($productReceiptionDetail);
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
    public function update(ProductReceiptionDetailFormData $request, $id)
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
        $productReceiptionDetail = ProductReceiptionDetail::find($id);
        if($productReceiptionDetail){
            $productReceiptionDetail->delete();
            return response()->json($productReceiptionDetail, 201);

        }else{
            return response()->json(['message'=>'не удалось удалить запись'],404);

        }

    }
}
