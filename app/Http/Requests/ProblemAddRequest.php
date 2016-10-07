<?php

namespace ESCOJ\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProblemAddRequest extends FormRequest
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
            'name' => 'required|max:200',
            'source' => 'required|integer', //exists:sources,id
            'description' => 'required|max:5000',
            'input_specification' => 'required|max:5000',
            'output_specification' => 'required|max:2000',
            'sample_input' => 'required|max:2000',
            'sample_output' => 'required|max:2000',
            'hints' => 'required|max:2000',
        ];
    }
}
