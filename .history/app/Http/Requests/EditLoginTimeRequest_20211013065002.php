<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditLoginTimeRe extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'login_date_time' => 'required|date_format:Y-m-d H:i'
        ];
    }
}
