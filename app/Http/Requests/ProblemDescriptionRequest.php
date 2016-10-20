<?php

namespace ESCOJ\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProblemDescriptionRequest extends FormRequest
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
        if($this->request->get('id')){
            $rules['name'] = 'required|max:200|unique:problems,name,'.$this->request->get('id');
        }
        else{
            $rules['name'] = 'required|max:200|unique:problems';
        }

        return array_merge($rules, [

            'source' => 'required|integer', //exists:sources,id
            'points' => 'required|integer|min:1|max:100', //exists:sources,id
            'description' => 'required|max:5000',
            'input_specification' => 'required|max:5000',
            'output_specification' => 'required|max:2000',
            'sample_input' => 'required|max:2000',
            'sample_output' => 'required|max:2000',
            'hints' => 'required|max:2000',
            'languages' => 'required|array',
            'tags' => 'required|array',
            'enable' => 'required|boolean',
            'multidata' => 'required|boolean',
        ]);
    }
}
