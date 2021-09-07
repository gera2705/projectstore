<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProjectStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()) // user is supervisor = create project
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
            "title" => "required|max:191",
            "places" => "required",
            "goal" => "required",
            "idea" => "required",
            "type_id" => "required",
            "date_start" => "required",
            "date_end" => "required",
            "requirements" => "required|max:355",
            "customer" => "required|max:255",
            "tags" => "required",
            "expected_result" => "required",
        ];
    }
}
