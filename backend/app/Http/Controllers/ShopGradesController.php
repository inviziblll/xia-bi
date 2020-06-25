<?php

namespace App\Http\Controllers;

use App\ShopGrades;
use Illuminate\Http\Request;
use App\Shop;

class ShopGradesController extends Controller
{

    protected $model;

    public function __construct()
    {
        $this->model = ShopGrades::class;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shopsGrades = ShopGrades::with('shop')->paginate(25);
        if($shopsGrades->count()){
            return response($shopsGrades);
        }else{
            return response()->json([], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $grade = $this->set_model($id = null, $model = $this->model, collect($request->only([
            'shop_id',
            'date',
            'tt_bonus',
            'tt_seperate'
        ])));
        return response(ShopGrades::with("shop")->find($grade->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shopGrade = ShopGrades::with('shop')->find($id);
        if($shopGrade){
            return response($shopGrade);
        }else{
            return response()->json([], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $grade = $this->set_model($id, $model = $this->model, collect($request->only([
            'shop_id',
            'date',
            'tt_bonus',
            'tt_seperate'
        ])));
        return response(ShopGrades::with("shop")->find($grade->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shopGrade = ShopGrades::find($id);
        if($shopGrade){
            $shopGrade->delete();
            return response()->json($shopGrade, 201);

        }else{
            return response()->json(['message'=>'не удалось удалить запись'],404);

        }
    }


}
