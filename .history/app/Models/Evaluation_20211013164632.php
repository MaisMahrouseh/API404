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

    public function gettUserWorkTimeCurrent($id){
    $loginInformation = $this
    ->select('login_date_time' , 'logout_date_time')
    ->where('user_id' , $id)
    ->whereMonth('login_date_time' , date('m'))
    ->whereYear('login_date_time' , date('Y'))
    ->get();

    $totalSec = 0;
    foreach( $loginInformation as $time){
      $StartTime = Carbon::parse($time->login_date_time);
      $EndTime = Carbon::parse($time->logout_date_time);
      $totalSec = $totalSec + 
    }

    }
}
