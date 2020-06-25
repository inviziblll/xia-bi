<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckHeaderFormData;
use Illuminate\Http\Request;
use App\CheckHeader;
use App\CheckDetail;
use App\CheckDiscount;

class CheckHeaderController extends Controller
{

    protected $model;

    public function __construct()
    {
        $this->model = CheckHeader::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkHeaders = CheckHeader::with(["cashdesk", "checkoperation","discounts","checkdetail","card"]);

        ini_set('memory_limit', '512M');

        if($checkHeaders->count()){
            return response($checkHeaders->paginate(25));
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
    public function store(CheckHeaderFormData $request)
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
        $checkHeader = CheckHeader::with(["cashdesk", "checkoperation","checkdetail","discounts","card"])->find($id);
        if($checkHeader){
            return response($checkHeader);
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
    public function update(CheckHeaderFormData $request, $id)
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
       $checkHeader = CheckHeader::find($id);

        if($checkHeader){
            // $checkHeader->checkdetail()->delete();
            // $checkDetails = CheckDetail::where('check_header_id', '=', $checkHeader->id);
            // dd($checkDetails->toArray());
           // $checkDetails = CheckDetail::where('check_header_id', '=', $checkHeader->id)->delete();
            $checkHeader->delete();
            return response()->json($checkHeader, 201);

        }else{
            return response()->json(['message'=>'не удалось удалить запись'],404);

        }
    }

    public function checkheader_add_discount(Request $request, $id_check_header){

        $search = CheckDiscount::where('discount_id', $request->get('id'))->where('check_header_id', $id_check_header)->get();
        if($search->count() === 0){
            CheckDiscount::create($request->all());
        }

    }
}
