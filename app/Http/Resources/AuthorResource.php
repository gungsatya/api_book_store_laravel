<?php

namespace App\Http\Resources;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Author
 */
class AuthorResource extends JsonResource
{
    public static $wrap = 'author';
    protected string $message;

    /**
     * @param Author $resource
     * @param string $message
     */
    public function __construct($resource, string $message = 'Success to get author data')
    {
        parent::__construct($resource);
        $this->message = $message;
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'dob' => $this->dob->format('Y-m-d'),
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }

    public function with($request): array
    {
        return [
            'message' => $this->message
        ];
    }
}
