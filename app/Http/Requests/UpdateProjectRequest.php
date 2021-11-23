<?php 

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends ApiRequest
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
        'title' => 'string',
        'places' => 'int',
        'difficulty' => 'int',
        'date_start' => 'string',
        'date_end' => 'string',
        'goal' => 'string',
        'idea' => 'string',
        'customer' => 'string',
        'type' => 'int',
        'requirements' => 'string',
        'tags' => 'array|min:0'
      ];
    }
}
