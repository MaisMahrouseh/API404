<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Entrie extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'user_id' ,'login_date_time','logout_date_time' ,'status'];
    protected $date = ['login_date_time','logout_date_time'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getLastLoginInformation(){
       $LastLoginInformation = $this
       ->select('status','login_date_time','logout_date_time')
       ->where('user_id' , auth()->user()->id)
       ->orderBy('id' , 'desc')
       ->first();
       return $LastLoginInformation;
    }

    public function login(){
        return   $this->create([
            'user_id' => auth()->user()->id,
            'login_date_time' => now(),
             'status' => '1'
        ]);
    }

    public function logout(){
        $LastID = $this
        ->select('id')
        ->where('user_id' , auth()->user()->id)
        ->orderBy('id' , 'desc')
        ->first();
        $out = Entrie::where('id' , $LastID->id)->update([
            'logout_date_time' => now(),
            'status' => '0'
        ]);
        return $out;
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
          $totalSec = $totalSec + $EndTime->diffInSeconds($StartTime);
        }
        $WorkTime  = gmdate("H:i:s" ,  $totalSec);
         return  $WorkTime;
        }

    public function gettUserWorkTimespecificMonth($request , $id){
        $month = Carbon::parse($request->date)->format('m');
        $year = Carbon::parse($request->date)->format('Y');
        $loginInformation = $this
        ->select('login_date_time' , 'logout_date_time')
        ->where('user_id' , $id)
        ->whereMonth('login_date_time' , $month)
        ->whereYear('login_date_time' ,  $year)
        ->get();

        $totalSec = 0;
        foreach( $loginInformation as $time){
          $StartTime = Carbon::parse($time->login_date_time);
          $EndTime = Carbon::parse($time->logout_date_time);
          $totalSec = $totalSec + $EndTime->diffInSeconds($StartTime);
        }
        $WorkTime  = gmdate("H:i:s" ,  $totalSec);
         return  $WorkTime;
        }

    public function gettUserWorkTimespecificDate($request , $id){
        $loginInformation = $this
        ->select('login_date_time' , 'logout_date_time')
        ->where('user_id' , $id)
        ->whereDate('login_date_time' , $request->date)
        ->get();

        $totalSec = 0;
        foreach( $loginInformation as $time){
          $StartTime = Carbon::parse($time->login_date_time);
          $EndTime = Carbon::parse($time->logout_date_time);
          $totalSec = $totalSec + $EndTime->diffInSeconds($StartTime);
        }
        $WorkTime  = gmdate("H:i:s" ,  $totalSec);
         return  $WorkTime;
        }
    
}
