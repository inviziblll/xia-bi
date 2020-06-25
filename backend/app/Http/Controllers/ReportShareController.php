<?php

namespace App\Http\Controllers;

use App\ReportShare;
use Illuminate\Http\Request;

class ReportShareController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reportShares = ReportShare::with('user', 'report')->get();

        if(count($reportShares)==0){
            return response()->json([]);
        }

        return response($reportShares);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $data = array_merge(['user_id'=>$user->id], $request->all());

//        dd($request->all());
        $reportshare = ReportShare::with('user', 'report')->updateOrCreate($data);

        return response($reportshare);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reportshare = ReportShare::with('user', 'report')->find($id);

        if(!$reportshare){
            return response()->json(['message'=>'такого отчета не существует'], 404);
        }
        return response($reportshare);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reportshare = ReportShare::find($id);

        if(!$reportshare){
            return response()->json(['message'=>'Невозможно удалить отчет']);
        } else {
            $reportshare->delete();
            return response($reportshare);
        }
    }
}
