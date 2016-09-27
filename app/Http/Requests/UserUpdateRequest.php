<?php

namespace ESCOJ\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserUpdateRequest extends FormRequest
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
            'name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'email' => 'required|email|max:60|unique:users,email,'.Auth::user()->id,
            'password' => 'min:6|confirmed',
            'country' => 'required',
            'institution' => 'required',
            'avatar' => 'image|max:35|dimensions:width=120,height=120',
        ];
    }

}
