<?php

namespace App\Http\Controllers;

use App\Http\Requests\VisitLogFormData;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\VisitLog;
use App\Shop;

class VisitLogController extends Controller
{

    protected $model;

    public function __construct()
    {
        $this->model = VisitLog::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       /*
       $visitLogs = VisitLog::paginate(1000);
        if($visitLogs->count()){
            return response($visitLogs);
        }else{
            return response()->json(['message'=>'записей нет'], 404);
        }*/
        
        
        $visitLogs = VisitLog::with(["shop"]);
        if($request->shops){
            $visitLogs = $visitLogs->whereHas(
                'shop',function (Builder $query) use ($request){
                $query->whereIn('id', explode(',',$request->shops));
            });
        }
        if($request->date_to) $visitLogs->where('date','<=', $request->date_to);
        if($request->date_from) $visitLogs->where('date','>=', $request->date_from);
        
        
        if($visitLogs->count()){
           // return response($visitLogs->get());
           return response($visitLogs->paginate(25));
        }
        return response()->json(['message'=>'записей нет'], 404);


    }




    public function search(Request $request)
    {
        $visitLogs = VisitLog::with(["shop"]);
        if($request->search){
            $visitLogs = $visitLogs->whereHas(
                'shop',function (Builder $query) use ($request){
                $query->whereIn('id', explode(',',$request->search));
            });
        }
        if($request->date_to) $visitLogs->where('date','<=', $request->date_to);
        if($request->date_from) $visitLogs->where('date','>=', $request->date_from);
        $visitLogs->paginate(25);
        if($visitLogs->count()){
            return response($visitLogs->get());
        }
        return response()->json(['message'=>'записей нет'], 404);
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VisitLogFormData $request)
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
        $visitLog = VisitLog::find($id);
        if($visitLog){
            return response($visitLog);
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
    public function update(VisitLogFormData $request, $id)
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
        $visitLog = VisitLog::find($id);
        if($visitLog){
            $visitLog->delete();
            return response()->json($visitLog, 201);

        }else{
            return response()->json(['message'=>'не удалось удалить запись'],404);

        }
    }
}
