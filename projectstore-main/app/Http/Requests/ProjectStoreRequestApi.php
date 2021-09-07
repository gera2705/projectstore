<?php

namespace App\Http\Requests;

use App\Http\Requests\ApiRequest;

class ProjectStoreRequestApi extends ApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "title" => ["required"],
            "places" => ["required"],
            "state" => ["required"],
            "type" => ["required"],
            "goal" => ["required"],
            "idea" => ["required"],
            "date_start" => ["required"],
            "date_end" => ["required"],
            "requirements" => ["required"],
            "customer" => ["required"],
            "expected_result" => ["required"],
        ];
    }
}
