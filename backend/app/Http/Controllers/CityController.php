<?php

namespace App\Http\Controllers;
use App\Http\Requests\CityFormData;
use Illuminate\Http\Request;
use App\City;

 /*
  *
  *
  * */

class CityController extends Controller
{


    protected $model;

    public function __construct()
    {
        $this->model = City::class;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $cities = City::all();
        if($cities->count()){
            return response($cities);
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

    public function store(CityFormData $request)
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
        $city  = City::find($id);

        if($city){
            return response($city);
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
    public function update(CityFormData $request, $id)
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
        $city  = City::find($id);
        if($city){
            $city->delete();

            return response()->json($city, 201);
        }else{

            return response()->json(['message'=>'не удалось удалить запись'],404);
        }
    }


}
