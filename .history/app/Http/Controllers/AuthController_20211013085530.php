<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Entrie;
use App\Models\Absence;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use \Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Nullable;
use function PHPUnit\Framework\isNull;

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




    /*public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        Entrie::create([
            'user_id' => auth()->user()->id,
            'logout_date_time' => now(),
            'status' => '0'
        ]);
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }


    public function AddlogoutTime(Request $request){
         $day = Carbon::now()->subDay(1)->toDateString();
         if ($day == 'Friday'){
            $day = Carbon::now()->subDay(2)->toDateString();
            }
         $time = Carbon::parse($request->logout_date_time)->toTimeString();

        $token = $request->user()->token();
        $token->revoke();
        Entrie::create([
            'user_id' => auth()->user()->id,
            'logout_date_time' => $day.' '.$time,
            'status' => '0'
        ]);
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);

    }






     public function logoutInAbsence(Request $request){
        $status = Entrie::select('login_date_time')->where('user_id' , auth()->user()->id)->orderBy('id' , 'desc')->first();
        $time = Carbon::parse($request->logout_date_time)->toTimeString();
        $day = Carbon::parse($status->login_date_time)->toDateString();
        $token = $request->user()->token();
        $token->revoke();
        Entrie::create([
            'user_id' => auth()->user()->id,
            'logout_date_time' => $day.' '.$time,
            'status' => '0'
        ]);
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
     }
    public function AddAbsenceDate(abcence $request){
        $request->validated();
        $status = Entrie::select('login_date_time')->where('user_id' , auth()->user()->id)->orderBy('id' , 'desc')->first();
        $period = CarbonPeriod::create($status->login_date_time, Carbon::today());
        foreach ($period as $date) {
            if( Carbon::parse($status->login_date_time)->toDateString() != $date->toDateString() && $date->isoFormat('dddd') != 'Friday')
                 $listOfDates[] = $date->format('Y-m-d');
        }

         if(in_array($request->absence_date	, $listOfDates)){
            $abc =  Absence::create([
                'user_id' => auth()->user()->id,
                'absence_date' => $request->absence_date,
                'reason' => $request->reason
            ]);
         }
         if ($abc -> save())
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

*/
}
