<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['id', 'user_id' ,'task','task_date'];

    protected $hidden = [ 'deleted_at', 'created_at', 'updated_at' ,'user_id'];


    public function user()
    {
        return $this->belongsTo(User::class)->select(['id', 'name']);;
    }

    public function gettUserTasksspecificMonth($request ,$id){
        $month = Carbon::parse($request->date)->format('m');
        $year = Carbon::parse($request->date)->format('Y');

        $UserTasks = $this
        ->select('id' , 'task' , 'task_date')
        ->where('user_id' , $id)
        ->whereMonth('task_date' , $month)
        ->whereYear('task_date' , $year)
        ->get();
        $UserTasks;
    }

    public function gettUserTasksspecificDate($request ,$id){
        $UserTasks = $this
        ->select('id' , 'task' , 'task_date')
        ->where('user_id' , $id)
        ->whereDate('task_date' , $request->date)
        ->get();
        return $UserTasks;
    }

}
