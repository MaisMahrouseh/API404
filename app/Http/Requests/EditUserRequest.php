<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' =>'required|regex:/^[a-zA-Z\s]+$/',
            'email' =>[ 'required', Rule::unique('users', 'email')->ignore($this->user) ],
            'password' =>'required|min:6',
            'gender' => ['required',Rule::in('male','fmale')],
            'date' =>'required|date|before:tomorrow',
            'Permittivity' =>['required',Rule::in('Admin','Employee')],
        ];
    }
}
