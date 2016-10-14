<?php

namespace ESCOJ\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProblemAssignLimitsRequest extends FormRequest
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

            'limits.*.ml' => 'required|digits_between:1,10',
            'limits.*.sl' => 'required|digits_between:1,10',
            'limits.*.tlpc' => 'required|digits_between:1,10',
            'limits.*.ttl' => 'required|digits_between:1,10',

            'limits.*.ml_multiplier' => 'sometimes|required|numeric',
            'limits.*.sl_multiplier' => 'sometimes|required|numeric',
            'limits.*.tlpc_multiplier' => 'sometimes|required|numeric',
            'limits.*.ttl_multiplier' => 'sometimes|required|numeric',
            
        ];
    }

    public function messages()
    {
        $messages = [];

        foreach($this->request->get('limits') as $key => $val)
        {
            $language = '';
            
            if($key)
            {
                $language = 'for ' . $val['name'] . ' ';

                $messages['limits.' .$key. '.tlpc_multiplier.required'] = 'The Time Limit Per Case Multiplier ' . $language . 'is required.';
                $messages['limits.' .$key. '.ttl_multiplier.required'] = 'The Total Time Limit Multiplier ' . $language . 'is required.';
                $messages['limits.' .$key. '.ml_multiplier.required'] = 'The Memory Limit Multiplier ' . $language . 'is required.';
                $messages['limits.' .$key. '.sl_multiplier.required'] = 'The Source Limit Multiplier ' . $language . 'is required.';

                $messages['limits.' .$key. '.tlpc_multiplier.numeric'] = 'The Time Limit Per Case Multiplier ' . $language . 'must be a number.';
                $messages['limits.' .$key. '.ttl_multiplier.numeric'] = 'The Total Time Limit Multiplier ' . $language . 'must be a number.';
                $messages['limits.' .$key. '.ml_multiplier.numeric'] = 'The Memory Limit Multiplier ' . $language . 'must be a number.';
                $messages['limits.' .$key. '.sl_multiplier.numeric'] = 'The Source Limit Multiplier ' . $language . 'must be a number.';
            }

            $messages['limits.' .$key. '.tlpc.required'] = 'The Time Limit Per Case field ' . $language . 'is required.';
            $messages['limits.' .$key. '.ttl.required'] = 'The Total Time Limit field ' . $language . 'is required.';
            $messages['limits.' .$key. '.ml.required'] = 'The Memory Limit field ' . $language . 'is required.';
            $messages['limits.' .$key. '.sl.required'] = 'The Source Limit field ' . $language . 'is required.';

            $messages['limits.' .$key. '.tlpc.digits_between'] = 'The Time Limit Per Case ' . $language . 'must be between :min and :max digits.';
            $messages['limits.' .$key. '.ttl.digits_between'] = 'The Total Time Limit ' . $language . 'must be between :min and :max digits.';
            $messages['limits.' .$key. '.ml.digits_between'] = 'The Memory Limit ' . $language . 'must be between :min and :max digits.';
            $messages['limits.' .$key. '.sl.digits_between'] = 'The Source Limit ' . $language . 'must be between :min and :max digits.';
        }

        return $messages;
    }
}
