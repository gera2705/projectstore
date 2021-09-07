<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidateStoreRequestApi extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fio'=>'required|max:191',
            'email'=>'required|max:191',
            'phone'=>'required|max:191',
            'competencies'=>'required|max:255',
            'skill'=>'required',
            'course'=>'required',
            'training_group'=>'required',
            'experience'=>'required',
        ];
    }
}
