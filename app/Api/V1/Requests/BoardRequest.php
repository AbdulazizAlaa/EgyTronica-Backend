<?php

namespace App\Api\V1\Requests;

use Config;
use Dingo\Api\Http\FormRequest;
// use Illuminate\Foundation\Http\FormRequest;
// use Illuminate\Contracts\Validation\Validator;

class BoardRequest extends FormRequest
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
        return Config::get('boilerplate.create_board.validation_rules');
    }

    /**
     * {@inheritdoc}
     */
    // protected function formatErrors(Validator $validator)
    // {
    //     return $validator->errors()->all();
    // }
}
