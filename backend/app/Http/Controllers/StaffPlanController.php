<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaffPlanFormData;
use Illuminate\Http\Request;
use App\StaffPlan;

class StaffPlanController extends Controller
{

    protected $model;

    public function __construct()
    {
        $this->model = StaffPlan::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staffplans = StaffPlan::with([
            'shops',
            'roles',
        ])->get();
        if($staffplans->count()){
            return response($staffplans);
        }else{
            return response()->json(['message'=>'записей нет'], 404);
        }
    }

    public function getStaffPlans(Request $request)
    {
        $sortBy = $request->query('sortBy');
        $descending = $request->query('descending');
        $rowsPerPage = $request->query('rowsPerPage');

        if ($descending == "true") {
            $descending = "asc";
        } else {
            $descending = "desc";
        }

        $staffplans = [];

        if ($sortBy == 'roles.name') {

            $staffplans = StaffPlan::
                join('roles', 'StaffPlan.role_id', '=', 'roles.id')
                ->select('StaffPlan.*', 'roles.name')
                ->with(['shops', 'roles'])
                ->orderBy('roles.name', $descending)
                ->paginate($rowsPerPage);

        } else {

            $staffplans = StaffPlan::
                join('shops', 'StaffPlan.shop_id', '=', 'shops.id')
                ->select('StaffPlan.*', 'shops.name')
                ->with(['shops', 'roles'])
                ->orderBy('shops.name', $descending)
                ->paginate($rowsPerPage);

        }







        if($staffplans->count()){
            return response($staffplans);
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
    public function store(StaffPlanFormData $request)
    {
        $request->offsetUnset("shops");
        $request->offsetUnset("users");
        $request->offsetUnset("shifts");
        $request->offsetUnset("roles");

        $staffplan = StaffPlan::updateOrCreate($request->all());
        $staffplan->load(["users"]);
        $staffplan->load(["shops"]);
        $staffplan->load(["shifts"]);
        $staffplan->load(["roles"]);
        return response($staffplan);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $staffplan  = StaffPlan::with(["users", "shops", "shifts","roles"])->find($id);
        if($staffplan){
            return response($staffplan);
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
    public function update(StaffPlanFormData $request, $id)
    {
        $request->offsetUnset("shops");
        $request->offsetUnset("users");
        $request->offsetUnset("shifts");
        $request->offsetUnset("roles");

        $staffplan = StaffPlan::with(["users", "shops", "shifts","roles"])->updateOrCreate(['id'=>$id],$request->all());

        return response($staffplan);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $staffplan  = StaffPlan::find($id);

        if($staffplan->count()>0){
            $staffplan->delete();
            return response()->json($staffplan, 201);

        }else{
            return response()->json(['message'=>'не удалось удалить запись'],404);

        }
    }
}
