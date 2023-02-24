<?php

namespace App\Http\Requests;

use App\Rules\LimitBookPriceRule;
use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    public function attributes(): array
    {
        return [
            'author_id' => "book's author id",
            'title' => "book's title",
            'description' => "book's description",
            'price' => "book's price",
            'release_date' => "book's released date",
            'cover_image' => "book's cover",
            'tag_ids' => "book's tag ids"
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
            'author_id' => [
                'required',
                'integer',
                'exists:authors,id'
            ],
            'title' => [
                'required',
                'string'
            ],
            'description' => [
                'nullable',
                'string'
            ],
            'price' => [
                'required',
                'double',
                new LimitBookPriceRule()
            ],
            'release_date' => [
                'required',
                'date',
                'date_format:Y-m-d'
            ],
            'cover_image' => [
                'nullable',
                'image',
                'dimensions:min_width=100,min_height=200',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048'
            ],
            'tag_ids' => [
                'nullable',
                'array'
            ],
            'tag_ids.*' => [
                'integer',
                'exists:tags,id'
            ]
        ];
    }
}
