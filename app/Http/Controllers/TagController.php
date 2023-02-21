<?php

namespace App\Http\Controllers;

use App\Http\Requests\CollectionRequest;
use App\Http\Resources\TagCollection;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Throwable;

/**
 * TagController
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 */
class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CollectionRequest $request
     * @return ResourceCollection
     */
    public function index(CollectionRequest $request): ResourceCollection
    {
        $keyword = $request->input('q', '');
        $tags = Tag::query()
            ->where('name', 'like', "%$keyword%")
            ->paginate($this->perPageSize($request->pageSize));

        return new TagCollection($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param TagRepository $repository
     * @return TagResource
     * @throws Throwable
     */
    public function store(Request $request, TagRepository $repository): TagResource
    {
        $created = $repository->create($request->only('name'));

        return new TagResource($created, "Tag has been created.");
    }


    /**
     * Remove the specified resource from storage.
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
