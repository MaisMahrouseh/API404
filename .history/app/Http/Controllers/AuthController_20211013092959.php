<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\AddAbsenceRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Entrie;
use App\Models\Absence;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Http\myResponse\myResponse;


class AuthController extends Controller
{
    public $entrie;
    public $absence;
    public $response;

    public function __construct(Entrie $entrie ,Absence $absence , myResponse $response){
        $this->entrie = $entrie;
        $this->absence = $absence;
        $this->response = $response;
    }

    public function login(LoginUserRequest $request){
        $validated = $request->validated();
        if (Auth::attempt($validated)) {
        $user = $request->user();
        $tokenResult = $user->createToken('LaravelAuthApp');
        $LastLoginInformation = $this->entrie->getLastLoginInformation();

        //تسجيل دخول (في حالة مافي ركورد ف هاد أول تسجيل دخول)
        if($LastLoginInformation === null ){
           
            return response()->json([
              'success' => true,
              'token' => $tokenResult,
              ], 200);
           }
        }
    }

}
