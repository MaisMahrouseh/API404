<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddAbsenceRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'absence_date' =>'required|date',
            'reason' =>'required',
        ];
    }
}
