
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginUser;
use App\Http\Requests\abcence;
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
    public function login(LoginUser $request)
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

            $day = Carbon::parse($status->login_date_time)->addDays(1)->isoFormat('dddd');
            $currentday = Carbon::today()->isoFormat('dddd');
            if ($day == 'Friday'){
            $day = Carbon::parse($status->login_date_time)->addDays(2)->isoFormat('dddd');
             }
             //فحص اذا بدو يسجل دخول ومو مسجل خروجو امبارح
            if($status->status == 1 && $day == $currentday ){
                return response()->json(['message' => 'Please enter your exit time yesterday' ]);
            }


            $lastAbsence =  Absence::select('absence_date')->where('user_id' , auth()->user()->id)->orderBy('id' , 'desc')->first();
            $last =  Carbon::parse($lastAbsence->absence_date)->addDays(1);
             //اذا سجل دخول وغاب كم يوم واجا ديسجل دخول
             if( $status->status == 1 && $status->login_date_time < Carbon::today() && $last != Carbon::today()){
                $period = CarbonPeriod::create($status->login_date_time, Carbon::today());
                $cont = 0;
                foreach ($period as $date) {
                  $listOfDates[] = $date->isoFormat('dddd');
                  if($date->isoFormat('dddd') != 'Friday')
                  $cont++;
                }
                $cont--;
                return response()->json([
                    'message1' => 'Please enter your exit time in ' . Carbon::parse($status->login_date_time)->format('Y-m-d'),
                    'message2' => 'Please enter the reason for your absence in the past' .' ' .$cont.' '. 'days']);
            }

           //اذا سجل دخول وخروج بيوم وبعدا  وغاب كم يوم واجا ديسجل دخول
           //متل فوق بس حالة تكون 0



            //اذا مسجل دخول واجا يسجل دخول
            if( $status->status == 1){
                 return response()->json(['message' => 'you are logged']);
              }
         }
         else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }}



    public function logout (Request $request) {
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


}
