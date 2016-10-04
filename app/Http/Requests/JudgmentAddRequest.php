<?php

namespace ESCOJ\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JudgmentAddRequest extends FormRequest
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
            'problem_id' => 'integer|required|max:10000',
            'language' => 'required',
            'code' => 'required_without:your_code_in_the_editor|file|mimes:c,c++,java,py,txt|max:100',
            'your_code_in_the_editor' => 'required_without:code|string|max:10000',
        ];
    }
}
