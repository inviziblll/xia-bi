<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckDetailFormData;
use Illuminate\Http\Request;
use App\CheckDetail;


class CheckDetailController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = CheckDetail::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd('---');
        $checkDetails = CheckDetail::with("checkheader","product","user","checktype")->paginate(100);

        $checkDetails->load(["checkheader"=> function($value){
            $value->with("card");
        }]);

        if($checkDetails->count()){
            return response($checkDetails);
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
    public function store(CheckDetailFormData $request)
    {
        $CheckDetail = $this->set_model(null,$this->model,collect($request->only([
            'amount',
            'check_header_id',
            'count',
            'price',
            'product_id',
            'user_id'
        ])));
        return response(CheckDetail::with("product","checkheader","user","checktype")->find($CheckDetail->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $checkDetail = CheckDetail::with("checkheader","product","user","checktype")->find($id);

        $checkDetail->load(["checkheader"=> function($value){
            $value->with("card");
        }]);
        if($checkDetail){
            return response($checkDetail);
        }else{
            return response()->json(['message'=>'запись не найдена'], 404);
        }

    }

    public function checkdetail_by_checkheader($id_checkheader){

        $checkdetails = CheckDetail::with("checkheader","product","user","checktype")->where("check_header_id","=",$id_checkheader)->get();

        if(count($checkdetails)>0){
            return response($checkdetails);
        }else {
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
    public function update(CheckDetailFormData $request, $id)
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
        $checkDetail = CheckDetail::find($id);

        if($checkDetail){
            $checkDetail->delete();
            return response()->json($checkDetail, 201);

        }else{
            return response()->json(['message'=>'не удалось удалить запись'],404);

        }
    }
}
