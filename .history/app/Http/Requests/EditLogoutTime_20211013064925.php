<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditLogoutTime extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'logout_date_time' => 'required|date_format:Y-m-d H:i'
        ];
    }
}
