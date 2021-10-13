<?php

namespace App\Http\Requests;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AddUserRequest extends FormRequest
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
            'email' =>'required|email|unique:users',
            'password' =>'required|min:6',
            'gender' => ['required',Rule::in('male','fmale')],
            'date' =>'required|date|before:tomorrow',
            'Permittivity' =>['required',Rule::in('Admin','Employee')],
        ];
    }
}
