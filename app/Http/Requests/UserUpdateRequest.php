<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => [
                'integer'
            ],
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
                Rule::unique('users')->ignore($this->id),
                'max:255',
            ],
            'birth_date' => [
                'date',
                'date_format:Y-m-d',
                'before_or_equal:' . Carbon::now()->subYears(18)->format('Y-m-d')
            ],
            'is_admin' => [
                'required',
            ]
        ];
    }
}
