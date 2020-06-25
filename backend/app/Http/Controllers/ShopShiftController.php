<?php

namespace App\Http\Controllers;
use App\Http\Requests\ShopShiftFormData;
use Illuminate\Http\Request;

use League\Csv\Reader;
use League\Csv\Statement;

use App\ShopShift;
use App\Shop;
use App\User;
use App\Shift;
use App\Role;

class ShopShiftController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = ShopShift::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shopshifts = ShopShift::all();
        if($shopshifts->count()){
            return response($shopshifts);
        }
        else{
            return response()->json(['message'=>'записей нет'], 404);
        }
    }

    public function getShopShifts(Request $request)
    {
        $sortBy = $request->query('sortBy');
        $descending = $request->query('descending');
        $rowsPerPage = $request->query('rowsPerPage');
        $searchText = $request->query('searchText');

        if ($descending == "true") {
            $descending = "asc";
        } else {
            $descending = "desc";
        }

        $shopshifts = [];

        if ($sortBy == 'roles.name') {

            $shopshifts = ShopShift::
            join('roles', 'StaffPlan.role_id', '=', 'roles.id')
                ->select('StaffPlan.*', 'roles.name')
                ->with(['shops', 'roles', 'shifts', 'users'])
                ->orderBy('roles.name', $descending)
                ->paginate($rowsPerPage);

        } elseif ($sortBy == 'shops.name') {

            $shopshifts = ShopShift::
            join('shops', 'StaffPlan.shop_id', '=', 'shops.id')
                ->select('StaffPlan.*', 'shops.name')
                ->with(['shops', 'roles', 'shifts', 'users'])
                ->orderBy('shops.name', $descending)
                ->paginate($rowsPerPage);

        } elseif ($sortBy == 'shifts.name') {

            $shopshifts = ShopShift::
            join('Shift', 'StaffPlan.shift_id', '=', 'Shift.shiftId')
                ->select('StaffPlan.*', 'Shift.name')
                ->with(['shops', 'roles', 'shifts', 'users'])
                ->orderBy('Shift.name', $descending)
                ->paginate($rowsPerPage);

        } elseif ($sortBy == 'users.name') {

            $shopshifts = ShopShift::
            join('users', 'StaffPlan.user_id', '=', 'users.id')
                ->select('StaffPlan.*', 'users.name')
                ->with(['shops', 'roles', 'shifts', 'users'])
                ->orderBy('users.name', $descending)
                ->paginate($rowsPerPage);

        } elseif ($sortBy == 'date') {

            $shopshifts = ShopShift::
                with(['shops', 'roles', 'shifts', 'users'])
                ->orderBy('date', $descending)
                ->paginate($rowsPerPage);

        }


        if($shopshifts->count()){
            return response($shopshifts);
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
    public function store(ShopShiftFormData $request)
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
        $shopshift  = ShopShift::find($id);

        if($shopshift){
            return response($shopshift);
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
    public function update(ShopShiftFormData $request, $id)
    {
       $staff_plan = ShopShift::updateOrCreate(['id'=>$id],$request->all());
        return response($staff_plan);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shopshift  = ShopShift::find($id);
        if($shopshift){
            $shopshift->delete();
            return response()->json($shopshift, 201);

        }else{
            return response()->json(['message'=>'не удалось удалить запись'],404);

        }

    }


    public function upload(Request $request){
        // dd('--- shop_shift upload ---');

        $file = $request->file('file');

        // $csv_file =  $file->storeAs('upload', $file_name);
        // $file_path = 'storage/app/'.$csv_file;


        if($file){

            $basenamefile = $file->getClientOriginalName();
            $extends = substr($basenamefile, strpos($basenamefile, '.', -5));

            if($extends == '.csv'){
                // сохраняем файл и записываем данные в таблицу
                $file_name = md5($basenamefile).$extends;
                $csv_file =  $file->storeAs('upload', $file_name);
                $file_path = 'storage/app/'.$csv_file;

                $this->read_csv(base_path().'/'.$file_path);
            }

        }


    }


    public function read_csv($csv_file){

        //load the CSV document from a stream
        $stream = fopen($csv_file, 'r');
        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        //build a statement
        $stmt = (new Statement())
            ->offset(10)
            ->limit(25);

        //query your records from the document
        $records = $stmt->process($csv);

        // массивы сущностей
        $shops = [];
        $users = [];
        $shifts = [];
        $shop_shifts = [];

        foreach ($records as $record) {

            // dd($record['ФИО продавца']);
            // $shop = Shop::where('name', $record['магазин'])->first();
            // $user = User::where('name', $record['ФИО продавца'])->first();
            // $role = Role::where('name', $record['должность'])->first();
            // $date = $record['дата'];
            // $shift = Shift::where('name', $record['Смена'])->first();

            $user_id = 0;
            $shift_id = 0;

            if(isset($shops[$record['магазин']])){
                $shop_id = $shops[$record['магазин']];
            }
            else{
                $shop_id = Shop::where('name', $record['магазин'])->first()->toArray()['id'];
                $shops[$record['магазин']] = $shop_id;
            }

            if(isset($users[$record['ФИО продавца']])){
                $user_id = $users[$record['ФИО продавца']];
            }
            else{
                if($user = User::where('name', $record['ФИО продавца'])->first()){
                    $user_id = $user->toArray()['id'];
                    $users[$record['ФИО продавца']] = $user_id;
                }
            }


            if(isset($shifts[$record['Смена']])){
                $shift_id = $shifts[$record['Смена']];
            }
            else{
                //$shift_id = '';
                if($shift = Shift::where('name', $record['Смена'])->first()){
                    $shift_id = $shift->toArray()['id'];
                    $shifts[$record['Смена']] = $shift_id;
                }
            }


            if($user_id){
                $shopShift = ShopShift::create([
                    'shop_id' => $shop_id,
                    'user_id'=> $user_id,
                    'role_id'=> 1,
                    'shift_id'=> $shift_id,
                    'date'=> $record['День']
                ]);
            }

            $shop_shifts[] = $shopShift->toArray();

            // dd($shopShift->toArray());
        }

        // dd($users);
        // dd($shifts);
        return $shop_shifts;

    }
}
