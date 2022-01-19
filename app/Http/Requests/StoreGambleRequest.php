<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGambleRequest extends FormRequest
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
            'chosen_money' => [
                'required',
            ],
            'chosen_team' => [
                'required',
            ],
            'game_id' => [
                'required',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'chosen_money.required' => 'Dit veld is verplicht anders kan je geen gok plaatsen.'
        ];
    }
}
