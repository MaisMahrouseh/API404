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
             return  $this->response->returnError('Please enter the reason for your absence in the past' .' ' .$cont.' '. 'days🌝' ,  403);
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




                  if($cont <= 0)
                     return response()->json([
                        'message1' => 'Please enter your exit time in ' . Carbon::parse($LastLoginInformation->login_date_time)->format('Y-m-d')]);
                  return response()->json([
                    'message1' => 'Please enter your exit time in ' . Carbon::parse($LastLoginInformation->login_date_time)->format('Y-m-d'),
                    'message2' => 'Please enter the reason for your absence in the past' .' ' .$cont.' '. 'days🌝']);
               }
           }
           if($LastAbsenceDate != null){
            $LastAbsenceDateAddNextDay =  Carbon::parse($LastAbsenceDate->absence_date)->addDays(1);
            if($LastLoginInformation->status == 1 && $LastLoginInformation->login_date_time < Carbon::today() && $LastAbsenceDateAddNextDay != Carbon::today()){
                $period = CarbonPeriod::create($LastAbsenceDateAddNextDay , Carbon::today());
                $cont = 0;
                foreach ($period as $date) {
                  $listOfDates[] = $date->isoFormat('dddd');
                  if($date->isoFormat('dddd') != 'Friday')
                  $cont++;
                }
                $cont--;
                if($cont <= 0)
                   return response()->json([
                      'message1' => 'Please enter your exit time in ' . Carbon::parse($LastLoginInformation->login_date_time)->format('Y-m-d')]);
                return response()->json([
                    'message1' => 'Please enter your exit time in ' . Carbon::parse($LastLoginInformation->login_date_time)->format('Y-m-d'),
                    'message2' => 'Please enter the reason for your absence in the past' .' ' .$cont.' '. 'days']);
            }
           }

           //اذا سجل دخول وخروج وغاب كم يوم واجا يسجل دخول لازم يسجل اسباب غياباتو
           if($LastAbsenceDate == null){
            if($LastLoginInformation->status == 0 && $LastLoginInformation->login_date_time < Carbon::today()){
               $period = CarbonPeriod::create($LastLoginInformation->login_date_time, Carbon::today());
               $cont = 0;
               foreach ($period as $date) {
                 $listOfDates[] = $date->isoFormat('dddd');
                 if($date->isoFormat('dddd') != 'Friday')
                 $cont++;
               }
               $cont--;
               if($cont <= 0)
                   return response()->json([
                     'message1' => 'Please enter your exit time in ' . Carbon::parse($LastLoginInformation->login_date_time)->format('Y-m-d')]);
               return $this->response->returnError('Please enter the reason for your absence in the past' .' ' .$cont.' '. 'days🌝' , 403);
            }
        }
        if($LastAbsenceDate != null){
            $LastAbsenceDateAddNextDay =  Carbon::parse($LastAbsenceDate->absence_date)->addDays(1);
            if($LastLoginInformation->status == 0 && $LastLoginInformation->login_date_time < Carbon::today() && $LastAbsenceDateAddNextDay != Carbon::today()){
                $period = CarbonPeriod::create($LastAbsenceDateAddNextDay , Carbon::today());
                $cont = 0;
                foreach ($period as $date) {
                  $listOfDates[] = $date->isoFormat('dddd');
                  if($date->isoFormat('dddd') != 'Friday')
                  $cont++;
                }
                $cont--;
                if($cont <= 0)
                    return response()->json([
                       'message1' => 'Please enter your exit time in ' . Carbon::parse($LastLoginInformation->login_date_time)->format('Y-m-d')]);
                return $this->response->returnError('Please enter the reason for your absence in the past' .' ' .$cont.' '. 'days🌝' , 403);
            }
           }

            //اذا مسجل دخول واجا يسجل دخول
            if( $LastLoginInformation->status == 1)
            return $this->response->returnError('you are logged🤨' , 403);


        }
        return $this->response->returnError('Unauthorised' , 401);

    }*/
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

    //تسجيل الخروج في حال نسي يسجل امبارح
    public function AddlogoutTimeYesterday(Request $request){
        $request->validate([
            'logout_date_time' => 'required|date_format:H:i'
        ]);
       $token = $request->user()->token();
       $token->revoke();

       $day = Carbon::now()->subDay(1)->toDateString();
       if ($day == 'Friday')
          $day = Carbon::now()->subDay(2)->toDateString();
       $time = Carbon::parse($request->logout_date_time)->toTimeString();

       $LastID = $this->entrie
       ->select('id' , 'login_date_time')
       ->where('user_id' , auth()->user()->id)
       ->orderBy('id' , 'desc')
       ->first();

       $lastTime = Carbon::parse($LastID->login_date_time)->toTimeString();
       if( $lastTime  > $time )
           return $this->response->returnError('The time must be greater than'. $lastTime  , 403);

           $out = $this->entrie->where('id' , $LastID->id)->update([
           'logout_date_time' => $day.' '.$time,
           'status' => '0'
       ]);

       if($out)
       return  $this->response->returnSuccess('You have been successfully logged out!' , 200);
    return $this->response->returnError('Exit error' , 500);
   }


   //تسجيل الخروج في حالة الغياب
   public function logoutInAbsence(Request $request){
    $request->validate([
        'logout_date_time' => 'required|date_format:H:i'
    ]);
    $token = $request->user()->token();
    $token->revoke();
    $LastLoginInformation = $this->entrie
       ->select('id' , 'login_date_time')
       ->where('user_id' , auth()->user()->id)
       ->orderBy('id' , 'desc')
       ->first();

        $time = Carbon::parse($request->logout_date_time)->toTimeString();
        $day = Carbon::parse($LastLoginInformation->login_date_time)->toDateString();
        $lastTime = Carbon::parse($LastLoginInformation->login_date_time)->toTimeString();
        if( $lastTime  > $time )
            return $this->response->returnError('The time must be greater than'. $lastTime  , 403);

            $out = $this->entrie->where('id' , $LastLoginInformation->id)->update([
            'logout_date_time' => $day.' '.$time,
            'status' => '0'
        ]);

        if($out)
        return  $this->response->returnSuccess('You have been successfully logged out!' , 200);
     return $this->response->returnError('Exit error' , 500);
   }

   public function AddAbsenceDate(AddAbsenceRequest $request){
    $request->validated();
    $LastLoginInformation = Entrie::select('login_date_time')->where('user_id' , auth()->user()->id)->orderBy('id' , 'desc')->first();
    $period = CarbonPeriod::create($LastLoginInformation->login_date_time, Carbon::today());
    foreach ($period as $date) {
        if( Carbon::parse($LastLoginInformation->login_date_time)->toDateString() != $date->toDateString() && $date->isoFormat('dddd') != 'Friday')
             $listOfDates[] = $date->format('Y-m-d');
    }
    if(in_array($request->absence_date	, $listOfDates)){
        $abcsenc = $this->absence->create([
            'user_id' => auth()->user()->id,
            'absence_date' => $request->absence_date,
            'reason' => $request->reason
        ]);
        if ($abcsenc)
        return  $this->response->returnSuccess('Added successfully' , 200);
     }

    return $this->response->returnError('Not Added' , 403);
   }
}
