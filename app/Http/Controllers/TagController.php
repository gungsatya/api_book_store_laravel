<?php

namespace App\Http\Controllers;

use App\Http\Requests\CollectionRequest;
use App\Http\Resources\TagCollection;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Validator;
use Throwable;

/**
 * @group Tag Management
 *
 * API collection to manage tags data.
 *
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 */
class TagController extends Controller
{
    /**
     * Tag Collection
     *
     * Get tag collection
     *
     * @queryParam q string Searching keyword of the collection. Example: Encyclopedia
     * @queryParam pageSize int Count of items per page. Allowed size 10, 25, 50, 100. Default 10. Example: 10
     * @queryParam page int Page index to view. Example: 1
     *
     * @bodyParam q string Searching keyword of the collection. Example: Encyclopedia
     * @bodyParam pageSize int Count of items per page. Allowed size 10, 25, 50, 100. Default 10. Example: 10
     *
     * @apiResourceCollection App\Http\Resources\TagCollection
     * @apiResourceModel App\Models\Tag
     *
     * @param CollectionRequest $request
     * @return ResourceCollection
     */
    public function index(CollectionRequest $request): ResourceCollection
    {
        $keyword = $request->input('q', '');
        $tags = Tag::query()
            ->where('name', 'like', "%$keyword%")
            ->paginate($request->input('pageSize', 10));

        return new TagCollection($tags);
    }

    /**
     * Store new tag
     *
     * Store a newly created tag in database.
     *
     * @bodyParam name string required Tag's name. Example: Magazine
     *
     * @response 201 {
     *      "tag": {
     *          "id": 2,
     *          "name": "Magazine"
     *      },
     *      "message": "Tag has been created."
     * }
     * @apiResourceModel App\Models\Tag
     *
     * @param Request $request
     * @param TagRepository $repository
     * @return TagResource
     * @throws Throwable
     */
    public function store(Request $request, TagRepository $repository): TagResource
    {
        $payload = $request->only('name');

        $validator = Validator::make(
            $payload,
            [
                'name' => [
                    'required',
                    'string'
                ]
            ],
            [
                'name' => "tag's name"
            ]
        );
        $validator->validate();

        $created = $repository->create($payload);

        return new TagResource($created, "Tag has been created.");
    }


    /**
     * Delete tag
     *
     * Remove the specified tag from database.
     *
     * @urlParam id int required Tag ID. Example: 1
     *
     * @response 200 {
     *      "tag": {
     *          "id": 2,
     *          "name": "Magazine"
     *      },
     *      "message": "Tag has been deleted."
     * }
     * @apiResourceModel App\Models\Tag
     *
     * @param TagRepository $repository
     * @param Tag $tag
     * @return TagResource
     * @throws Throwable
     */
    public function destroy(TagRepository $repository, Tag $tag): TagResource
    {
        $repository->forceDelete($tag);

        return new TagResource($tag, "Tag has been deleted.");
    }
}
