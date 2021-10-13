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
        
                return response()->json([
                  'success' => true,
                  'token' => $tokenResult,
                  ], 200);
               }
            }
}}
