<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorRequest extends FormRequest
{
    public function attributes(): array
    {
        return [
            'name' => "author's name",
            'dob' => "author's date of birth",
            'description' => "author's description"
        ];
    }

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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
            ],
            'dob' => [
                'required',
                'date',
                'date_format:Y-m-d'
            ],
            'description' => [
                'nullable',
                'string'
            ]
        ];
    }
}
