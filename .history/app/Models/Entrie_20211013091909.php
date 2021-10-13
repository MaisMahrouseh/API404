<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrie extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'user_id' ,'login_date_time','logout_date_time' ,'status'];
    protected $date = ['login_date_time','logout_date_time'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getLogin
}
