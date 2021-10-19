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

        //تسجيل دخول
        if($LastLoginInformation == null ){
           $this->entrie->login();
           return  $this->response->returnData('Welcome❤️' , $tokenResult , 200);
           }

           //اذا نسي يسجل خروج
           $currentday = Carbon::today()->format('Y-m-d');
           if($LastLoginInformation->logout_date_time == null && Carbon::parse($LastLoginInformation->login_date_time)->format('Y-m-d')  != $currentday)
           return $this->response->returnError('Please enter your exit time in' .Carbon::parse($LastLoginInformation->login_date_time)->format('Y-m-d') , 403);

           //اذا غاب
           if(Carbon::parse($LastLoginInformation->login_date_time)->format('Y-m-d') < $currentday){
            $LastAbsenceDates = $this->absence->getLastAbsenceDates();
               if($LastAbsenceDates == null){
                   $period = CarbonPeriod::create($LastLoginInformation->login_date_time , Carbon::today());
                   $cont = 0;
                   foreach ($period as $date) {
                      if($date->isoFormat('dddd') != 'Friday' && Carbon::parse($LastLoginInformation->login_date_time)->toDateString() != $date->toDateString()){
                         Absence::insert([
                        'user_id' => auth()->user()->id,
                        'absence_date' => $date,
                      ]);
                   $cont++;}
               }
               if( $cont )
             return  $this->response->returnError('Please enter the reason for your absence in the past' .' ' .$cont.' '. 'days🌝' ,  403);
           }
           if($LastAbsenceDates->absence_date != null){
            if(Carbon::parse($LastAbsenceDates->absence_date)->addDay(1)->format('Y-m-d') !=  $currentday){

            }
           }
        }


           //اذا مسجل دخول واجا يسجل دخول
           if( $LastLoginInformation->logout_date_time == null)
           return $this->response->returnError('you are logged🤨' , 403);


           //تسجيل دخول
          if($LastLoginInformation->logout_date_time != null){
          $this->entrie->login();
          return  $this->response->returnData('Welcome❤️' , $tokenResult , 200);
          }
        }
    }



    //تسجيل الخروج في الحالة الطبيعية
    public function logout(Request $request){
        $token = $request->user()->token();
        $token->revoke();
        $out = $this->entrie->logout();
        if($out)
          return  $this->response->returnSuccess('You have been successfully logged out!' , 200);
       return $this->response->returnError('Exit error' , 500);
    }

    //تسجيل الخروج في حال نسي
    public function AddlogoutTime(Request $request){
        $request->validate([
            'logout_date_time' => 'required|date_format:H:i'
        ]);
       $token = $request->user()->token();
       $token->revoke();
       $LastLoginInformation = $this->entrie->getLastLoginInformation();
       $lastTime = Carbon::parse($LastLoginInformation->login_date_time)->toTimeString();
       $lastDate = Carbon::parse($LastLoginInformation->login_date_time)->toDateString();
       if( $lastTime  > $request->logout_date_time )
           return $this->response->returnError('The time must be greater than'. $lastTime  , 403);

        $out = $this->entrie->where('id' , $LastLoginInformation->id)->update([
           'logout_date_time' => $lastDate.' '.$request->logout_date_time,
       ]);

       if($out)
       return  $this->response->returnSuccess('You have been successfully logged out!' , 200);
    return $this->response->returnError('Exit error' , 500);
   }


   // نسجيل أسباب الغيااب
   public function AddAbsenceDate(AddAbsenceRequest $request){
    $request->validated();
    $AbsenceDates = $this->absence->getAbsenceDates();
    foreach ($AbsenceDates as $date) {
             $listOfDates[] = $date->absence_date;
    }
    if(in_array($request->absence_date	, $listOfDates)){
        $update = $this->absence->where('absence_date' , $request->absence_date)->update([
            'reason' => $request->reason
        ]);
        if ($update)
        return  $this->response->returnSuccess('Added successfully' , 200);
     }

    return $this->response->returnError('You are not absent in this day!', 403);
   }

}
