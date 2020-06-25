<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\ClientFormData;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::with("cards")->paginate(25);

        if($clients->count()==0){
            return response()->json(['message'=>'списка пустая']);
        }

        return response($clients);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientFormData $request)
    {
        $client = Client::with("cards")->updateOrCreate($request->all());

        return response($client);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::with("cards")->find($id);

        if(!$client){

            return response()->json(['message'=>'Клиент не найден']);

        }

        return response($client);
    }


    /**
     * @param ClientFormData $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(ClientFormData $request, $id)
    {

        $client = Client::with('cards')->updateOrCreate(['id'=>$id],$request->all());

        return response($client);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::with("cards")->find($id);

        if(!$client){
            return response()->json(['message'=>'невозможно удалить не существующего клиента']);
        }
        $client->delete();
        return response()->json(['message'=>'Клиент был удален']);
    }
}
