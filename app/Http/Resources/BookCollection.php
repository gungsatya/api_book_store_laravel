<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

class BookCollection extends ResourceCollection
{
    public static $wrap = 'books';
    protected string $message;

    /**
     * @param $resource
     * @param string $message
     */
    public function __construct($resource, string $message = 'Success to get book collection')
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
        return BookResource::collection($this->collection);
    }

    public function with($request): array
    {
        return [
            'message' => $this->message
        ];
    }
}
