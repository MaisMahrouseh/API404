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

    public function logoutTimeYesterday(){
        $day = Carbon::now()->subDay(1)->toDateString();
        if ($day == 'Friday')
           $day = Carbon::now()->subDay(2)->toDateString();

           
    }
}
