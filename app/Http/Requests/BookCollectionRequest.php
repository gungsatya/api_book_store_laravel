<?php

namespace App\Http\Requests;

use App\Rules\AllowedPageSizeRule;
use App\Rules\TagIdsSearchRule;
use Illuminate\Foundation\Http\FormRequest;

class BookCollectionRequest extends FormRequest
{

    public function attributes(): array
    {
        return [
            'tag_ids' => 'tag ids',
            'pageSize' => 'page size',
            'q' => 'keyword'
        ];
    }

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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'pageSize' => [
                'nullable',
                'numeric',
                new AllowedPageSizeRule(),
            ],
            'q' => [
                'nullable',
                'string'
            ],
            'tag_ids' => [
                'nullable',
                'string',
                new TagIdsSearchRule()
            ],
        ];
    }
}
