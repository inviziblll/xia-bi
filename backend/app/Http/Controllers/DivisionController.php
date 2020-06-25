<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Division;
use App\Http\Requests\DivisionFormData;
use Illuminate\Validation;

class DivisionController extends Controller
{

//    protected $rules;
//
//    public function __construct() {
//
//        // parent::__construct();
//        $this->rules = [
//            'name' => 'required|string|min:0|max:255',
//            'description' => 'required|string|min:0|max:255',
//            'user_id' => 'required|integer',
//        ];
//
//    }

    protected $model;

    public function __construct()
    {
        $this->model = Division::class;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function index(Request $request)
    {
        $devisions = Division::all();
        if($devisions->count()){
            return response($devisions);
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
    public function store(DivisionFormData $request)
    {
        return response($this->set_model($id = null, $model = $this->model, $request));

    }

//    public function division_validate($request){
//
//            $validator = Validator::make($request->all(), $this->rules);
//
//            if ($validator->fails()) {
//                return redirect('post/create')
//                    ->withErrors($validator)
//                    ->withInput();
//            }
//            return $validator;
//    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $devision = Division::find($id);

        if($devision){
            return response($devision);
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
    public function update(DivisionFormData $request, $id)
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

        $division = Division::find($id);
        if($division ){
            $division ->delete();
            return response()->json($division, 201);

        }else{
            return response()->json(['message'=>'не удалось удалить запись'],404);

        }

    }





}
