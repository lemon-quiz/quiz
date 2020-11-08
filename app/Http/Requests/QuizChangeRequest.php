<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuizChangeRequest extends FormRequest
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
            'name' => 'required',
            'lang_a' => 'required',
            'lang_b' => 'required',
            'active' => 'boolean',
            'items' => 'required|array',
            'items.*.item_a' => 'required',
            'items.*.item_b' => 'required',
            'items.*.group' => 'required|integer',
        ];
    }
}
