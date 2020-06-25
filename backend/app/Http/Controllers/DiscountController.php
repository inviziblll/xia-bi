<?php

namespace App\Http\Controllers;

use App\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discounts = Discount::paginate(25);

        if(!$discounts->count()){
            return response()->json(['message'=>'Нет наличия']);
        }

        return response($discounts);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $discount = Discount::with('checkDiscounts')->updateOrCreate($request->all());
        return response($discount);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $discount = Discount::find($id);

        if(!$discount){
            return response()->json(['message'=>'Нет наличия']);
        }
        return response($discount);
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
        $discount = Discount::find($id);

        if(!$discount){
            return response()->json(['message'=>'Нет наличия']);
        }

        $discountUP = $discount->updateOrCreate(['id'=>$id],$request->all());

        return response($discountUP);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $discount = Discount::with('checkDiscounts')->find($id);

        if(!$discount){
            return response()->json(['message'=>'Нет наличия']);
        }
        $discount->delete();

        return response($discount);
    }
}
