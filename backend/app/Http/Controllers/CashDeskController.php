<?php

namespace App\Http\Controllers;

use App\Http\Requests\CashDeskFormData;
use Illuminate\Http\Request;
use App\CashDesk;


class CashDeskController extends Controller
{

    protected $model;

    public function __construct()
    {
        $this->model = CashDesk::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cashDesks = CashDesk::paginate(100);
        if($cashDesks->count()){
            return response($cashDesks);
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
    public function store(CashDeskFormData $request)
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
        $cashDesk = CashDesk::find($id);
        if($cashDesk){
            return response($cashDesk);
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
    public function update(CashDeskFormData $request, $id)
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
        $cashDesk = CashDesk::find($id);
        if($cashDesk){
            $cashDesk->delete();
            return response()->json($cashDesk, 201);

        }else{
            return response()->json(['message'=>'не удалось удалить запись'],404);

        }
    }
}
