<?php

namespace ESCOJ\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContestDescriptionRequest extends FormRequest
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
        //dd($this->request->all());
        if($this->request->has('id')){
            $rules['name'] = 'required|max:250|unique:contests,name,'.$this->request->get('id');
        }
        else{
            $rules['name'] = 'required|max:250|unique:contests';
        }
        if($this->request->has('offcontest')){
            $rules = array_merge($rules, [
                'offcontest' => 'required|boolean',
                'offcontest_penalization' => 'required_with:offcontest|integer|min:0|max:60',
                'offcontest_start_date' => 'required_with:offcontest|date_format:d-m-Y# g:i a|after:end_date|before:offcontest_end_date',
                'offcontest_end_date' => 'required_with:offcontest|date_format:d-m-Y# g:i a|after:offcontest_start_date',
            ]);
        }

        return array_merge($rules, [

            'organization_id' => 'required|integer', //exists:sources,id
            'penalization' => 'required|integer|min:0|max:60', //exists:sources,id
            'frozen_time' => 'required|integer|min:0|max:200',
            'access_type' => 'required|string|min:0|max:30',
            'description' => 'required|max:5000',
            //'start_date' => 'required|date_format:d-m-Y# g:i a|after:now|before:end_date',
            'start_date' => 'required|date_format:d-m-Y# g:i a|before:end_date',
            'end_date' => 'required|date_format:d-m-Y# g:i a|after:start_date',
            'problems' => 'required|array',
            'users' => 'required_if:access_type,private|array',

        ]);
    }
}
