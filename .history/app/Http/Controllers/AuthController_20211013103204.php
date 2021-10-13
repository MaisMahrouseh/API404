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
           $LastInsert = Carbon::parse($LastLoginInformation->login_date_time)->addDays(1)->isoFormat('dddd');
           $currentday = Carbon::today()->isoFormat('dddd');
           if ($LastInsert == 'Friday')
              $LastInsert = Carbon::parse($LastLoginInformation->login_date_time)->addDays(2)->isoFormat('dddd');
           if($LastLoginInformation->status == 1 && $LastInsert == $currentday)
              return $this->response->returnError('Please enter your exit time yesterday😐' , 403);

           //اذا سجل دخول وغاب كذا يوم واجا يسجل دخول...لازم يسجل خروجو باخر يوم ويحط اسباب غياباتو بباقي الأيام
           $LastAbsenceDate = $this->absence->getLastAbsenceDate();
           if($LastAbsenceDate == null){
               if($LastLoginInformation->status == 1 && $LastLoginInformation->login_date_time < Carbon::today()){
                  $period = CarbonPeriod::create($LastLoginInformation->login_date_time, Carbon::today());
                  $cont = 0;
                  foreach ($period as $date) {
                    $listOfDates[] = $date->isoFormat('dddd');
                    if($date->isoFormat('dddd') != 'Friday')
                    $cont++;
                  }
                  $cont--;
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
                return $this->response->returnError('Please enter the reason for your absence in the past' .' ' .$cont.' '. 'days🌝' , 403);
            }
           }

            //اذا مسجل دخول واجا يسجل دخول
            if( $LastLoginInformation->status == 1)
            return $this->response->returnError('you are logged🤨' , 403);

            //هون بقا اذا بدو يسجل دخول
            if($LastLoginInformation === 0 ){
                $this->entrie->login();
                return  $this->response->returnData('Welcome❤️' , $tokenResult , 200);
                }










        }
    }

}
