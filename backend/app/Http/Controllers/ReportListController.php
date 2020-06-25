<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportFormData;
use App\ReportList;
use App\Scope\ReportScope;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportListController extends Controller
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
        $user = auth()->user();
        $reports = ReportList::where('user_id', $user->id)->get();

        if(count($reports)==0){
            return response()->json([]);
        }

        return response($reports);
    }


    /**
     * Store a newly created resource in storage.
     * @return \Illuminate\Http\Response
     */
    public function store(ReportFormData $request)
    {
        $user = auth()->user();

        $data = array_merge(['user_id'=>$user->id], $request->all());

        $report = ReportList::create($data);

        return response($report);
    }

    /**
     * Display the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = auth()->user();
        $report = ReportList::find($id);

        if(!$report){
            return response()->json(['message'=>'такого отчета не существует'], 404);
        }
        return response($report);
    }

    public function getDivisionMonthReport(){
        $data = DB::select('exec GetDivisionMonthReport');

        if(count($data)==0){
            return response()->json(['message'=>'таблица пустая'], 404);
        }
        return response($data);

    }
    public function getDivisionPieMonthReport(){
        $data = DB::select('exec GetDivisionPieMonthReport');
        if(count($data)==0){
            return response()->json(['message'=>'таблица пустая'], 404);
        }
        return response($data);

    }


    /**
     * Update the specified resource in storage
     * @param  \App\ReportList  $reportList
     * @return \Illuminate\Http\Response
     */
    public function update(ReportFormData $request, $id)
    {
        if(!(ReportList::find($id))){
            return response()->json(['message'=>'такого отчета не существует'], 404);
        }

        $user = auth()->user();

        $data = array_merge(['user_id'=>$user->id], $request->all());

        $report = ReportList::updateOrCreate(['id'=>$id], $data);
        $report->load("user");
        return response($report);

    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $report = ReportList::find($id);

        if(!$report){
            return response()->json(['message'=>'Невозможно удалить отчет']);
        } else {
            $report->delete();
            return response($report);
        }
    }
}
