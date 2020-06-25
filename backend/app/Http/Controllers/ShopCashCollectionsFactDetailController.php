<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopCashCollectionsDataStore;
use App\Http\Requests\ShopCashCollectionsFactDetailDataStore;
use App\ShopCashCollectionsFactDetail;
use Illuminate\Http\Request;

class ShopCashCollectionsFactDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shopCashCollectionFactDetails = ShopCashCollectionsFactDetail::with("shopCashCollection")->get();

        if($shopCashCollectionFactDetails->count()==0){
            return response()->json(['message'=> 'Нет записи']);
        }
        return response($shopCashCollectionFactDetails);
    }


    /**
     * @param ShopCashCollectionsFactDetailDataStore $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(ShopCashCollectionsFactDetailDataStore $request)
    {
        $shopCashCollectionFactDetail = ShopCashCollectionsFactDetail::updateOrCreate($request->all());

        $shopCashCollectionFactDetail->load("shopCashCollection");

        return response($shopCashCollectionFactDetail);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shopCashCollectionFactDetail = ShopCashCollectionsFactDetail::with("shop")->find($id);

        if(!$shopCashCollectionFactDetail){
            return response()->json(['message'=> 'Нет записи']);
        }
        return response($shopCashCollectionFactDetail);
    }


    /**
     * \Illuminate\Http\Response
     */
    public function update(ShopCashCollectionsFactDetailDataStore $request, $id)
    {
        $shopCashCollectionFactDetail = ShopCashCollectionsFactDetail::updateOrCreate(['id'=>$id], $request->all());

        $shopCashCollectionFactDetail->load("shopCashCollection");

        return response($shopCashCollectionFactDetail);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shopCashCollectionFactDetail = ShopCashCollectionsFactDetail::find($id);

        if(!$shopCashCollectionFactDetail){
            return response()->json(['message'=> 'Нет записи']);
        }
        $shopCashCollectionFactDetail->delete();
        return response()->json(['message'=> 'запись уделена']);
    }
}
