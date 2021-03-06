<?php 

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidateUpdateRequest extends ApiRequest
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
        'about' => 'required|string',
        'phone' => 'required|string',
        'skills' => 'present|array|min:0'
      ];
    }
}
