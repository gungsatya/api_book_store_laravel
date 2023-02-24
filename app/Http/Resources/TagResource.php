<?php

namespace App\Http\Resources;

use App\Models\Tag;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @mixin Tag
 */
class TagResource extends JsonResource
{
    public static $wrap = 'tag';
    private string $message;

    /**
     * @param Tag $resource
     * @param string $message
     */
    public function __construct($resource, string $message = 'Success to get tag data')
    {
        parent::__construct($resource);
        $this->message = $message;
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }

    public function with($request): array
    {
        return [
            'message' => $this->message
        ];
    }
}
