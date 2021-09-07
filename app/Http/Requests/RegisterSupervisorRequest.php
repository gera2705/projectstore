<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RegisterSupervisorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()->role == 'admin') // user is admin == create supervisor
            return true;
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "login" => "required|unique:users,username",
            "s_password" => "required|min:6",
            "s_fio" => "required",
            "s_email" => "required|email|unique:users,email",
            "position" => "required"
        ];
    }
}
