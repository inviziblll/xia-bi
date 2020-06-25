<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckTypeFormData;
use Illuminate\Http\Request;
use App\CheckType; 

class CheckTypeController extends Controller
{

    protected $model;

    public function __construct()
    {
        $this->model = CheckType::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkTypes = CheckType::paginate(100);
        if($checkTypes->count()){
            return response($checkTypes);
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
    public function store(CheckTypeFormData $request)
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
        $checkType = CheckType::find($id);
        if($checkType){
            return response($checkType);
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
    public function update(CheckTypeFormData $request, $id)
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
       $checkType = CheckType::find($id);
       if($checkType){
            $checkType->delete();
            return response()->json($checkType, 201);

        }else{
            return response()->json(['message'=>'не удалось удалить запись'],404);

        }
    }
}
