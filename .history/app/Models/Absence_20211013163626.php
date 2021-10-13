<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'user_id' ,'reason' , 'absence_date'];
    protected $date = ['absence_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getLastAbsenceDate(){
        $LastAbsenceDate =$this
        ->select('absence_date')
        ->where('user_id' , auth()->user()->id)
        ->orderBy('absence_date' , 'desc')
        ->first();
        return $LastAbsenceDate;
    }

    public function gettUserAbsenceCurrent($id){
        $UserAbsence = $this
        ->select('id' , 'absence_date' , 'reason')
        ->where()

    }
}
