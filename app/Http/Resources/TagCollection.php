<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

class TagCollection extends ResourceCollection
{
    public static $wrap = 'tags';
    protected string $message;

    /**
     * @param $resource
     * @param string $message
     */
    public function __construct($resource, string $message = 'Success to get tag collection')
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
    public function toArray($request)
    {
        return TagResource::collection($this->collection);
    }

    public function with($request): array
    {
        return [
            'message' => $this->message
        ];
    }
}
