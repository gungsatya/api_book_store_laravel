<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $q
 * @property-read int $pageSize
 */
class CollectionRequest extends FormRequest
{
    public function attributes(): array
    {
        return [
            'pageSize' => 'page size',
            'q' => 'keyword'
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
            'pageSize' => [
                'nullable',
                'integer',
                'in:10,25,50,100'
            ],
            'q' => [
                'nullable',
                'string'
            ]
        ];
    }
}
