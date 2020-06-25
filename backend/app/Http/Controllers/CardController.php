<?php

namespace App\Http\Controllers;

use App\Card;
use App\Http\Requests\CardFormData;
use App\User;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $card = Card::with("client")->paginate(25);

        return response($card);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  CardFormData  $request
     * @return \Illuminate\Http\Response
     */

    public function store(CardFormData $request)
    {

        $card = Card::with("client")->updateOrCreate($request->all());

        return response($card::with("client")->find($card->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $card = Card::with("client")->find($id);

        if(!$card){

            return response()->json(['message'=>'Катрта не найден']);

        }

        return response($card);
    }


    /**
     * @param CardFormData $request
     * @param Card $card
     */
    public function update(CardFormData $request, $id)
    {
        $card = Card::with('client')->updateOrCreate(['id'=>$id],$request->all());

        return response(Card::with("client")->find($card->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $card = Card::with("client")->find($id);

        if(!$card){

            return response()->json(['message'=>'невозможно удалить не существующего клиента']);

        }

        $card->delete();

        return response()->json(['message'=>'Катра был удалена']);
    }
}
