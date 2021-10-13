<?php

namespace App\Http\Controllers;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginUserRequest $request)
    {
        $validated = $request->validated();
        if (Auth::attempt($validated)) {
            $user = $request->user();
            $tokenResult = $user->createToken('LaravelAuthApp');
            $status = Entrie::select('status','login_date_time','logout_date_time')->where('user_id' , auth()->user()->id)->orderBy('id' , 'desc')->first();

              // اذا ديسجل دخول
              if($status === null || $status->status == 0){
                Entrie::create([
                   'user_id' => auth()->user()->id,
                   'login_date_time' => now(),
                    'status' => '1'
               ]);
                return response()->json([
                  'success' => true,
                  'token' => $tokenResult,
                  ], 200);
               }
            }
}
