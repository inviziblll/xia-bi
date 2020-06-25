<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormData; // класс валидации полей при создании новой записи
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; // модель пользователь
 
/**
 * UserController - CRUD контроллер для сущности User
 *
 */

class UserController extends Controller
{

    protected $model;

    public function __construct()
    {
        $this->model = User::class;
    }


    /**
     * GET, получить список пользователей
     * Request $request
     */

    /**
     * @SWG\Get(path="/api/users",
     *   tags={"user"},
     *   summary="Create user",
     *   description="This can only be done by the logged in user.",
     *   operationId="createUser",
     *   produces={"application/xml", "application/json"},
     *   @SWG\Response(response="default", description="successful operation")
     * )
     */
    public function index(Request $request)
    {

        $users = User::all();
        if($users->count()){
            return response($users);
        }else{
            return response()->json(['message'=>'записей нет'], 404);
        }
    }

    /**
     *
     * UserFormData
     * POST, создать запись
     * @param UserFormData $request
     */
    public function store(UserFormData $request)
    {
        $password = Hash::make($request->get('password'));
        $request->offsetSet('password', $password);

        $user = User::updateOrCreate(['email'=>$request->get('email')], $request->all());

        return response($user::find($user->id));
    }

//    public function store(UserFormData $request)
//    {
//        //dd($request);
//        $user = new User($request->getData());
//        if($user->save()){
//            return response([
//                'body'=> $user, 'action'=>'store', 'status'=>200
//            ]);
//        }
//    }


    /**
     * GET, получить запись по конкретному пользователю
     * @param  int  $id
     */
    public function show($id)
    {
        $user  = User::find($id);
        if($user){
            return response($user);
        }else{
            return response()->json(['message'=>'запись не найдена'], 404);
        }
    }


    /**
     * PUT, редактирование записи по конкретному пользователю
     * @param Request $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:0|max:255',
            'email' => 'required|email|min:0|max:255',
            'password' => 'nullable',
        ]);
        if (!$validator->fails()){
            if($request->get('password')==null){
                $request->offsetUnset("password");
            } else{
                $password = Hash::make($request->get('password'));
                $request->offsetSet('password', $password);
            }
            $user = User::updateOrCreate(['id'=>$id], $request->all());
        }

            return response($user::find($id));


    }


    /**
     * DELETE, удаляет запись по конкретному пользователю
     * @param  int  $id
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if($user){
            $user->delete();
            return response()->json($user, 201);

        }else{
            return response()->json(['message'=>'не удалось удалить запись'],404);

        }
    }

    /**
     * POST, поиск записей по полям name и email
     * @param Request $request
     */
    public function search(Request $request){
        $name = $request->name;
        $email = $request->email;
        $users = User::where('name', 'LIKE', '%'.$name.'%')->where('email','LIKE', '%'.$email.'%')->get();
        return response($users);
    }



}
