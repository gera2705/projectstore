<?php

namespace App\Http\Requests;

use App\Http\Requests\ApiRequest;

class LoginSupervisorRequestApi extends ApiRequest
{
    // There is no authorize method here, because the Api request is made here

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "login" => ["required"],
            "password"=>["required"],
        ];
    }
}
