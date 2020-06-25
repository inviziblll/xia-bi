<?php

namespace App\Http\Controllers;

use App\CheckBonus;
use Illuminate\Http\Request;

class CheckBonusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkBonuses = CheckBonus::with(["product" => function ($value){
            $value->with("groups");
        },
            "checkheader"=> function($value){
                $value->with(["checktype", "cashdesk", "checkoperation","discounts","checkdetail"]);
            }])->get();

        if($checkBonuses->count()==0){
            return response()->json(['message'=>'списка пустая']);
        }

        return response($checkBonuses);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $checkBonus = CheckBonus::updateOrCreate($request->all());

        $checkBonus->load(['checkheader'=> function($value){
            $value->with(["checktype", "cashdesk", "checkoperation","discounts","checkdetail"]);
        }]);

        $checkBonus->load(['product'=> function($value){
            $value->with("groups");
        }]);

        return response($checkBonus);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $checkBonus = CheckBonus::with("product","checkheader")->find($id);

        $checkBonus->load(['checkheader'=> function($value){
            $value->with(["checktype", "cashdesk", "checkoperation","discounts","checkdetail"]);
        }]);

        $checkBonus->load(['product'=> function($value){
            $value->with("groups");
        }]);
        if(!$checkBonus){
            return response()->json(['message'=>'ой ой ой нет такой записи']);
        }

        return response($checkBonus);
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
        $checkBonus = CheckBonus::find($id);

        if(!$checkBonus){
            return response()->json(['message'=>'списка пустая']);
        }

        $checkBonus = $checkBonus->updateOrCreate(['id'=>$id],$request->all());

        $checkBonus->load(['checkheader'=> function($value){
            $value->with(["checktype", "cashdesk", "checkoperation","discounts","checkdetail"]);
        }]);

        $checkBonus->load(['product'=> function($value){
            $value->with("groups");
        }]);

        return response($checkBonus);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $checkBonus = CheckBonus::find($id);

        if(!$checkBonus){
            return response()->json(['message'=>'списка пустая']);
        }

        $checkBonus = $checkBonus->delete($id);


        return response()->json(['message'=>'запись удалена']);
    }
}
