<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddEvaluationRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'user_id' => 'required|numeric',
            'evaluation_date' => 'required|date_format:Y-m',
            

        ];
    }
}
