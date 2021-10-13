<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    

}
