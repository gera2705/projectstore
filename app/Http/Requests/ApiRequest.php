<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class ApiRequest extends FormRequest
{
    // Используется для возможности вынесения валидации API в отдельные Requests, без этого кода и наследования от него
    // не достигается желаемое поведение
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            "errors"=>$validator->errors()
        ], 422));
    }
}
