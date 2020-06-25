<?php

namespace App\Http\Controllers;

use App\Http\Requests\CoeffFormData;
use Illuminate\Http\Request;
use App\Coeff; // модель пользователь

class CoeffController extends Controller
{

    protected $model;

    public function __construct()
    {
        $this->model = Coeff::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coeffs = Coeff::all();


        if($coeffs->count()){
            return response($coeffs);
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
    public function store(CoeffFormData $request)
    {

        if($request->date_from){
            $dayOfWeek = date('w',strtotime($request->date_from));
            // dd($dayOfWeek);
            $request->request->add(['day' => $dayOfWeek]);
        }
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
        $coeff = Coeff::find($id);
        if($coeff){
            return response($coeff);
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
    public function update(CoeffFormData $request, $id)
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
        $coeff  = Coeff::find($id);

        if($coeff){
            $coeff->delete();
            return response()->json($coeff, 201);

        }else{
            return response()->json(['message'=>'не удалось удалить запись'],404);

        }
    }


}
