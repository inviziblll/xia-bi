<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopCashCollectionsDataStore;
use App\ShopCashCollection;
use Illuminate\Http\Request;

class ShopCashCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shopCashCollections = ShopCashCollection::with("shop")->get();

        if($shopCashCollections->count()==0){
            return response()->json(['message'=> 'Нет записи']);
        }
        return response($shopCashCollections);
    }


    /**
     * @param ShopCashCollectionsDataStore $request
     */
    public function store(ShopCashCollectionsDataStore $request)
    {
        $shopCashCollection = ShopCashCollection::updateOrCreate($request->all());

        $shopCashCollection->load("shop");

        return response($shopCashCollection);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shopCashCollection = ShopCashCollection::with("shop")->find($id);

        if(!$shopCashCollection){
            return response()->json(['message'=> 'Нет записи']);
        }
        return response($shopCashCollection);
    }


    /**
     * \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $shopCashCollection = ShopCashCollection::updateOrCreate(['id'=>$id], $request->all());

        $shopCashCollection->load("shop");

        return response($shopCashCollection);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shopCashCollection = ShopCashCollection::with("shop")->find($id);

        if(!$shopCashCollection){
            return response()->json(['message'=> 'Нет записи']);
        }
        $shopCashCollection->delete();
        return response()->json(['message'=> 'запись уделена']);
    }
}
