<?php

namespace ESCOJ\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Route;

class InstitutionAddOrUpdateRequest extends FormRequest
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
        if(Route::current()->hasParameter('institution'))
            return [
                'name' => [
                    'required',
                    'max:120',
                    Rule::unique('institutions')->ignore(Route::current()->getParameter('institution')),
                ],
                'country' => 'required|integer|exists:countries,id',

            ];
       
        return [
            'name' => 'required|max:120|unique:institutions',
            'country' => 'required|integer|exists:countries,id',
        ];
    }
}
