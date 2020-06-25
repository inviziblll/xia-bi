<?php

namespace App\Http\Controllers;
use App\Http\Requests\CheckOperationFormData;
use Illuminate\Http\Request;
use App\CheckOperation;

class CheckOperationController extends Controller
{

    protected $model;

    public function __construct()
    {
        $this->model = CheckOperation::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkOperations = CheckOperation::paginate(100);
        if($checkOperations->count()){
            return response($checkOperations);
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
    public function store(CheckOperationFormData $request)
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
        $checkOperation = CheckOperation::find($id);
        if($checkOperation){
            return response($checkOperation);
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
    public function update(CheckOperationFormData $request, $id)
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
       $checkOperation = CheckOperation::find($id);
       if($checkOperation){
            $checkOperation->delete();
            return response()->json($checkOperation, 201);

        }else{
            return response()->json(['message'=>'не удалось удалить запись'],404);

        }
    }
}
