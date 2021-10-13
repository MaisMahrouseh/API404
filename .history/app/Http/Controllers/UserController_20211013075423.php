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
        return $this->res
        return response()->json([
            'success' => 'true',
            'data' => $user
        ],200);


    }

/*


    public function store(AddUsers $request)
    {
        $validated = $request->validated();
        $user =  User::create($validated);
        $user->createToken('LaravelAuthApp')->accessToken;
        if ($user -> save())
            return response()->json([
                'success' => true,
                'message' => 'Added successfully'
            ],200);
        else
            return response()->json([
                'success' => false,
                'message' => 'users not added'
            ], 500);
    }

    public function update(EditUsers $request, $id)
    {
        $validated = $request->validated();
        $user =  User::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'user not found'
            ], 400);
        }
        $updated = $user->update($validated);
        if ($updated)
            return response()->json([
                'success' => true,
                'message' => 'Edited successfully'
            ],200);
        else
            return response()->json([
                'success' => false,
                'message' => 'user can not be updated'
            ], 500);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'user not found'
            ], 400);
        }
        $deleted = $user->delete();
        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Deleted successfully'
            ],200);
        }
        else {
            return response()->json([
                'success' => false,
                'message' => 'user can not be deleted'
            ], 500);
        }


    }*/
}
