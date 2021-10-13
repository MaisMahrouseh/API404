<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Http\myResponse\myResponse;


class UserController extends Controller
{
    public $user;
    public $response;

    public function __construct(User $user , myResponse $response){
        $this->user = $user;
        $this->response = $response;
    }

    //عرض جميع المستخدمسن
    public function index()
    {
        $users = $this->user->gettAllUsers();
        return  $this->response->returnData('all Users' , $users , 200);
    }

    //عرض مستخدم معين
    public function show($id)
    {
        $user = $this->user->find($id);
        if (!$user)
            return $this->response->returnError('this user is not found' , 400);
        return $this->response->returnData('user where id '. $id . ' is:' , $user , 200);
    }

    //إضافة مستخدم
    public function store(AddUserRequest $request)
    {
        $validated = $request->validated();
        $user =  $this->user->create($validated);
        $user->createToken('LaravelAuthApp')->accessToken;
        if ($user)
            return  $this->response->returnSuccess('Added successfully' , 200);
         return $this->response->returnError('user not added' , 500);
    }

    //تعديل بيانات مستخدم
    public function update(EditUserRequest $request, $id)
    {
        $validated = $request->validated();
        $user =   $this->user->find($id);
        if (!$user)
           return $this->response->returnError('this user is not found' , 400);
        $updated = $user->update($validated);
        if ($updated)
            return  $this->response->returnSuccess('Edited successfully' , 200);
        return $this->response->returnError('user can not be updated' , 500);
    }

/*




    

    }*/
}
