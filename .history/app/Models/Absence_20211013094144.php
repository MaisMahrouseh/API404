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

    public 
}
