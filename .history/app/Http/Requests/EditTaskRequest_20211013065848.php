<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditTaskRequest extends FormRequest
{   protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'task' =>'required',
            'task_date' =>'required|date|before:tomorrow',
            'user_id' => 'required|numeric'
        ];
    }
}
