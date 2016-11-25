<?php

namespace ESCOJ\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Route;
use Illuminate\Validation\Rule;

class SourceAddOrUpdateRequest extends FormRequest
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
        //dd($this->route->hasParameter('source'));
        //dd($request->route('source'));
        if(Route::current()->hasParameter('source'))
            return [
                'name' => [
                    'required',
                    'max:120',
                    Rule::unique('sources')->ignore(Route::current()->getParameter('source')),
                ],
            ];
       
        return [
            'name' => 'required|max:120|unique:sources',
        ];
    }
}
