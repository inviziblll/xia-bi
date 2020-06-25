<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegionFormData;
use Illuminate\Http\Request;
use App\Region;
use App\User;
use App\Shop;
use Illuminate\Support\Facades\Validator;

class TestController extends Controller
{

    protected $rules;

    public function __construct() {

        //        $this->rules = [
        //            'name' => 'required|string|min:0|max:255',
        //            'description' => 'required|string|min:0|max:255',
        //            'user_id' => 'required|string|min:0|max:255',
        //        ];
    }


    public function index(Request $request)
    {
        $regions = Region::all();
        return response($regions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:0|max:255',
            // 'description' => 'required|string|min:0|max:255',
        ]);

        if($validator->fails()) {
            // dd(1);
            return response([
                'action'=>'store', 'status' => 400]
            );
        }
        else{
            // dd(0);
            $regions = new Region($request->toArray());
            $regions->save();
            return response([
                'body'=> $regions,'action'=>'store', 'status' => 200]
            );
        }
    }


    public function store2 (RegionFormData $request){
        return $request;
    }


    // users
    public function userslist(){
        return $this->item_list( User::class);
    }

    public function usersitem($id){
        return $this->get_item( User::class ,$id,[
            'division', 'role'
        ]);
    }


    public function search(Request $request){
        $name = $request->name;
        $email = $request->email;
        $users = User::where('name', 'LIKE', '%'.$name.'%')->where('email','LIKE', '%'.$email.'%')->get();
        return response($users);
    }

    // shops
    public function  shopslist(){
        return $this->item_list( Shop::class);
    }

    public function shopsitem($id){
        return $this->get_item( Shop::class ,$id,[
            'division', 'company'
        ]);
    }

    // roles
    public function  roleslist(){
        return $this->item_list( Role::class);
    }

    public function rolesitem($id){
        return $this->get_item( Role::class ,$id,[
            'user'
        ]);
    }

}
