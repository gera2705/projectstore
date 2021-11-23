<?php 

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProjectRequest extends ApiRequest
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
        'title' => 'required|string',
        'places' => 'required',
        'difficulty' => 'required',
        'date_start' => 'required|string',
        'date_end' => 'required|string',
        'goal' => 'required|string',
        'idea' => 'required|string',
        'customer' => 'required|string',
        'type' => 'required',
        'requirements' => 'required|string',
        'tags' => 'present|array|min:0'
      ];
    }
}
