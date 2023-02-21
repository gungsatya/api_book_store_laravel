<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

class AuthorCollection extends ResourceCollection
{
    public static $wrap = 'authors';
    protected string $message;

    /**
     * @param $resource
     * @param string $message
     */
    public function __construct($resource, string $message = 'Success to get author collection')
    {
        parent::__construct($resource);
        $this->message = $message;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return AuthorResource::collection($this->collection);
    }

    public function with($request): array
    {
        return [
            'message' => $this->message
        ];
    }
}
