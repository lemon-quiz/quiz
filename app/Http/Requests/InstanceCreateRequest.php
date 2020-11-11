<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstanceCreateRequest extends FormRequest
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
            'quiz_id' => 'required',
            'lang' => 'required',
            'num_questions' => 'required',
            'num_answers' => 'required|integer',
        ];
    }
}
