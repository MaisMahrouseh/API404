<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Absence extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'user_id' ,'reason' , 'absence_date'];
    protected $date = ['absence_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAbsenceDates(){
        $AbsenceDates =$this
        ->select('absence_date')
        ->where('user_id' , auth()->user()->id)
        ->orderBy('absence_date' , 'desc')
        ->first();
        return $LastAbsenceDate;
    }

    public function gettUserAbsenceCurrent($id){
        $UserAbsence = $this
        ->select('id' , 'absence_date' , 'reason')
        ->where('user_id' , $id)
        ->whereMonth('absence_date' , date('m'))
        ->whereYear('absence_date' , date('Y'))
        ->get();

        return $UserAbsence ;
    }

    public function gettUserAbsencespecificMonth($request ,$id){
        $month = Carbon::parse($request->date)->format('m');
        $year = Carbon::parse($request->date)->format('Y');

        $UserAbsence = $this
        ->select('id' , 'reason' , 'absence_date')
        ->where('user_id' , $id)
        ->whereMonth('absence_date' , $month)
        ->whereYear('absence_date' , $year)
        ->get();
        return $UserAbsence;
    }

    public function gettUserAbsencespecificDate($request ,$id){
        $UserAbsence = $this
        ->select('id' , 'reason' , 'absence_date')
        ->where('user_id' , $id)
        ->whereDate('absence_date' , $request->date)
        ->get();
        return $UserAbsence;
    }
}
