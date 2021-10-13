<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SearchDateRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Entrie;
use App\Models\Absence;
use App\Models\Task;
use App\Models\User;
use App\Models\Evaluation;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Http\myResponse\myResponse;

class AdminController extends Controller
{
    public $user;
    public $task;
    public $entrie;
    public $evaluation;
    public $absence;
    public $response;

    public function __construct(User $user, Task $task , Entrie $entrie ,Absence $absence ,Evaluation $evaluation, myResponse $response){
        $this->user = $user;
        $this->task = $task;
        $this->entrie = $entrie;
        $this->evaluation = $evaluation;
        $this->absence = $absence;
        $this->response = $response;
    }

    //عرض تفاصيل المستخدم في الشهر الحالي (مهامو ...غياباتو ..ساعات العمل...تقيمو)
    public function UserDetailsInCurrentMonth($id){
        $user = $this->user->find($id);
        if(!$user)
          return $this->response->returnError('this user is not found' , 400);
        $UserAndTasks = $this->user->gettUserTasksCurrent($id);
        $UserAbsence = $this->absence->gettUserAbsenceCurrent($id);
        $UserWorkTime = $this->entrie->gettUserWorkTimeCurrent($id);
        $UserEvaluation = $this->evaluation->gettUserEvaluationCurrent($id);

        return response()->json([
            'success' => true,
            'data' =>  $UserAndTasks,
            'Absence' =>  $UserAbsence,
            'WorkTime' =>  $UserWorkTime,
            'Evaluation' =>  $UserEvaluation,
        ], 200);
    }


     //عرض تفاصيل المستخدم في شهر محدد (مهامو ...غياباتو ..ساعات العمل...تقيمو)
     public function UserDetailsInspecificMonth(SearchDateRequest $$id){
        $user = $this->user->find($id);
        if(!$user)
          return $this->response->returnError('this user is not found' , 400);
        $UserAndTasks = $this->user->gettUserTasksCurrent($id);
        $UserAbsence = $this->absence->gettUserAbsenceCurrent($id);
        $UserWorkTime = $this->entrie->gettUserWorkTimeCurrent($id);
        $UserEvaluation = $this->evaluation->gettUserEvaluationCurrent($id);

        return response()->json([
            'success' => true,
            'data' =>  $UserAndTasks,
            'Absence' =>  $UserAbsence,
            'WorkTime' =>  $UserWorkTime,
            'Evaluation' =>  $UserEvaluation,
        ], 200);
    }

}
