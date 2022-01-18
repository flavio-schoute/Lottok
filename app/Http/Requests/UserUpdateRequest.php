<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'first_name' => [
                'required',
                'max:255',
                'string'
            ],
            'last_name' => [
                'required',
                'max:255',
                'string'
            ],
            'email' => [
                'required',
                'email',
                'max:255',
            ],
            'birthdate' => [
                'date',
                'date_format:Y-m-d'
            ],
            'is_admin' => [
                'required',
            ]
        ];
    }
}
