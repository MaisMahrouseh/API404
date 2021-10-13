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
        ->select('evaluation' , 'logout_date_time')
        ->where('user_id' , $id)
        ->whereMonth('login_date_time' , date('m'))
        ->whereYear('login_date_time' , date('Y'))
        ->get();

    }



}
