<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    use SoftDeletes;

    protected $fillable = [ 'id','name', 'email', 'password', 'date' , 'gender' ,'Permittivity'];


    protected $hidden = [ 'password', 'remember_token',];

    protected $casts = [  'email_verified_at' => 'datetime',];



    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function entries()
    {
        return $this->hasMany(Entrie::class);
    }

    public function absences()
    {
        return $this->hasMany(Absence::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function gettAllUsers(){
        $users = $this->select('id','name','email','password','date','gender')->get();
        $users -> makeVisible(['password']);
        return $users;
    }

    public function gettUserTasks($id){
        $userTasks = $this
        ->select('id','name')
        ->where('id' ,$id )
        ->with('tasks' , function($q){
            $q -> whereMonth('task_date' , date)
        })
        ->get();

        return $userTasks;
    }

}
