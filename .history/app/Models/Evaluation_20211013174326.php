<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Evaluation extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'user_id' ,'evaluation','evaluation_date'];

    protected $date = ['evaluation_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gettUserEvaluationCurrent($id){
        $UserEvaluation = $this
        ->select('evaluation' , 'evaluation_date')
        ->where('user_id' , $id)
        ->whereMonth('evaluation_date' , date('m'))
        ->whereYear('evaluation_date' , date('Y'))
        ->get();
        return $UserEvaluation;
    }

    public function gettUserEvaluationspecificMonth($request ,$id){
        $month = Carbon::parse($request->date)->format('m');
        $year = Carbon::parse($request->date)->format('Y');
        $UserEvaluation = $this
        ->select('evaluation' , 'evaluation_date')
        ->where('user_id' , $id)
        ->whereMonth('evaluation_date' ,$month)
        ->whereYear('evaluation_date' , $year)
        ->get();
        return $UserEvaluation;
    }



}
