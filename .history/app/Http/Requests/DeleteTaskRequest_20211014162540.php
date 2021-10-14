<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteTaskRequest extends FormRequest
{
   
    public function rules()
    {
        return [
            'user_id' => 'required|numeric'
        ];
    }
}
