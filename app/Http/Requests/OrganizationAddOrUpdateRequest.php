<?php

namespace ESCOJ\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Route;
use Illuminate\Validation\Rule;

class OrganizationAddOrUpdateRequest extends FormRequest
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
        //dd($this->route->hasParameter('organization'));
        //dd($request->route('organization'));
        if(Route::current()->hasParameter('organization'))
            return [
                'name' => [
                    'required',
                    'max:120',
                    Rule::unique('organizations')->ignore(Route::current()->getParameter('organization')),
                ],
            ];
       
        return [
            'name' => 'required|max:120|unique:organizations',
        ];
    }
}
