<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRemainFormData;
use App\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use App\ProductRemain;

class ProductRemainController extends Controller
{

    protected $model;

    public function __construct()
    {
        $this->model = ProductRemain::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $productRemains = ProductRemain::with(["product", "warehouse", "operation"]);

        if($request->product){
            $productRemains->whereHas('product',function (Builder $query) use ($request) {
                 $query->whereIn('id', explode(',',$request->product));
            });}

        if($request->warehouse){
             $productRemains->whereHas('warehouse', function (Builder $query) use ($request){
                    $query->whereIn('id', explode(',',$request->warehouse));
             });}

        if($request->operation){
            $productRemains->whereHas('operation', function (Builder $query) use ($request){
                    $query->whereIn('id', explode(',',$request->operation));
             });}
             
        if($request->date_to) $productRemains->where('date','<=', $request->date_to);
        if($request->date_from) $productRemains->where('date','>=', $request->date_from);


        if($productRemains->count()){
            return response($productRemains->paginate(25));
        }
        return response()->json(['message'=>'записей нет'], 404);
    }


    public function search(Request $request)
    {
        $productRemains = ProductRemain::with(["product", "warehouse", "operation"]);
        
        // if($request->remains){
            // $productRemains->whereHas(
            //     'product', function (Builder $query) use ($request) {
            //         $query->whereIn('id', explode(',',$request->remains));
            // })->orWhereHas(
            //     'warehouse',function (Builder $query) use ($request) {
            //         $query->whereIn('id', explode(',',$request->remains));
            // })->orWhereHas(
            //     'operation', function (Builder $query) use ($request) {
            //          $query->whereIn('id', explode(',',$request->remains));
            // });
        // }
        
        if($request->product){
            $productRemains->whereHas('product',function (Builder $query) use ($request) {
                 $query->whereIn('id', explode(',',$request->product));
            });}

        if($request->warehouse){
             $productRemains->whereHas('warehouse', function (Builder $query) use ($request){
                    $query->whereIn('id', explode(',',$request->warehouse));
             });}

        if($request->operation){
            $productRemains->whereHas('operation', function (Builder $query) use ($request){
                    $query->whereIn('id', explode(',',$request->operation));
             });}
        

        if($request->date_to) $productRemains->where('date','<=', $request->date_to);
        if($request->date_from) $productRemains->where('date','>=', $request->date_from);
    
        if($productRemains->count()){
            return response($productRemains->paginate(25));
        }

        return response()->json(['message'=>'записей нет'], 404);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRemainFormData $request)
    {
        return response($this->set_model($id = null, $model = $this->model, $request));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productRemain = ProductRemain::find($id);
        if ($productRemain) {
            return response($productRemain);
        } else {
            return response()->json(['message' => 'запись не найдена'], 404);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRemainFormData $request, $id)
    {
        return response($this->set_model($id, $model = $this->model, $request));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productRemain = ProductRemain::find($id);
        if ($productRemain) {
            $productRemain->delete();
            return response()->json($productRemain, 201);
        } else {
            return response()->json(['message' => 'не удалось удалить запись'], 404);
        }
    }

    protected function queryBuilder($relation, $query, $field){
        // return $query->where('name', 'like', '%' . $field . '%');
    }

    /**
     * POST, поиск записей по полям name и email
     * @param Request $request
     */
    /*public function search(Request $request)
    {

            $search = $request->search;

            // $resultProducts = Product::with("remains")->where('name', 'LIKE', '%'.$name.'%')->get()->toArray();

            //        $resultProducts = ProductRemain::with(["product", "warehouse", "operation"])
            //            ->whereHas(
            //                'product', function (Builder $query) use ($name) {
            //                $query->where('name', 'like', '%' . $name . '%');
            //            })
            //            ->orWhereHas(
            //                'warehouse', function (Builder $query) use ($name) {
            //                $query->where('name', 'like', '%' . $name . '%');
            //            })->limit(10)->get()->toArray();

            $resultProducts = ProductRemain::with(["product", "warehouse", "operation"])
                ->whereHas(
                    'product', function (Builder $query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')->orWhere('description', 'like', '%' . $search . '%');
                })->orWhereHas(
                    'warehouse', function (Builder $query) use ($search) {
                    $query->where('name', 'like', '%' . $search. '%')->orWhere('description', 'like', '%' . $search . '%');
                })->orWhereHas(
                    'operation', function (Builder $query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')->orWhere('description', 'like', '%' . $search. '%');
                })->paginate(100);

        return $resultProducts;


    }*/


}
