<?php 

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectFilterRequest extends ApiRequest
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
            'type' => 'present|array|min:0',
            'state' => 'present|array|min:0',
            'supervisor' => 'present|array|min:0',
            'tags' => 'present|array|min:0',
            'date_start' => 'required|string',
            'date_end' => 'required|string',
            'difficulty' => 'present|array|min:0',
            'title' => 'required|string'
        ];
    }
}
