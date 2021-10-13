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
           $this->entrie->login();
           return  $this->response->returnData('Welcome❤️' , $tokenResult , 200);
           }

           //اذا سجل دخول وراح واجا اليوم التاني ديسجل خروج...لازم يدخل وقت خروجو امبارح بعدا يسجل دخول
           $day = Carbon::parse($status->login_date_time)->addDays(1)->isoFormat('dddd');
           $currentday = Carbon::today()->isoFormat('dddd');
           if ($day == 'Friday'){
           $day = Carbon::parse($status->login_date_time)->addDays(2)->isoFormat('dddd');
            }






        }
    }

}
