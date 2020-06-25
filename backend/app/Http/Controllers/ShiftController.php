<?php

namespace App\Http\Controllers;
use App\Http\Requests\ShiftFormData;
use Illuminate\Http\Request;
use App\Shift;
use function PHPSTORM_META\map;

class ShiftController extends Controller
{

    protected $model;

    public function __construct()
    {
        $this->model = Shift::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shifts = Shift::all();
        if($shifts->count()){
            return response($shifts);
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
    public function store(ShiftFormData $request)
    {
        $data = $this->convert($request->all());

        $shift = Shift::updateOrCreate($data);

        return response($shift);
    }


    public function convert($arrays): array {
        $new = [];

        foreach ($arrays as $key => $value ){
            switch ($key){

                case "name":
                    $new["Name"] = $value;
                    break;
                case "hour_from":
                    $new["HourFrom"] = $value;
                    break;
                case "hour_to":
                    $new["HourTo"] = $value;
                    break;
                case "code":
                    $new["Code"] = $value;
            }
        }

        return $new;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $shift = Shift::find($id);


        if($shift){
            return response($shift);
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
    public function update(ShiftFormData $request, $id)
    {
        $data = $this->convert($request->all());

        $shift = Shift::updateOrCreate(['ShiftId'=>$id], $data);

        return response($shift);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shift = Shift::find($id);

        if($shift){
            $shift->delete();
            return response()->json($shift, 201);

        }else{
            return response()->json(['message'=>'не удалось удалить запись'],404);

        }
    }
}
