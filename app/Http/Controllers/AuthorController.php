<?php

namespace App\Http\Controllers;

use App\Http\Requests\CollectionRequest;
use App\Http\Resources\AuthorCollection;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use App\Repositories\AuthorRepository;
use Illuminate\Http\Request;
use Throwable;


/**
 * AuthorController
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 */
class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CollectionRequest $request
     * @return AuthorCollection
     */
    public function index(CollectionRequest $request): AuthorCollection
    {
        $authors = Author::search($request->q)
            ->paginate($this->perPageSize($request->pageSize));

        return new AuthorCollection($authors);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param AuthorRepository $repository
     * @return AuthorResource
     * @throws Throwable
     */
    public function store(Request $request, AuthorRepository $repository): AuthorResource
    {
        $created = $repository->create($request->only(['name', 'dob', 'description',]));

        return new AuthorResource($created, "Author has been saved.");
    }

    /**
     * Display the specified resource.
     *
     * @param Author $author
     * @return AuthorResource
     */
    public function show(Author $author): AuthorResource
    {
        return new AuthorResource($author);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Author $author
     * @param AuthorRepository $repository
     * @return AuthorResource
     * @throws Throwable
     */
    public function update(Request $request, Author $author, AuthorRepository $repository): AuthorResource
    {
        $repository->update($author, $request->only([
            'name',
            'dob',
            'description',
        ]));

        return new AuthorResource($author, "Author has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Author $author
     * @param AuthorRepository $repository
     * @return AuthorResource
     * @throws Throwable
     */
    public function destroy(Author $author, AuthorRepository $repository): AuthorResource
    {
        $repository->forceDelete($author);

        return new AuthorResource($author, "Author has been deleted");
    }
}
