<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Http\Resources\AuthorCollection;
use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


/**
 * AuthorController
 * @author satya.wibawa
 */
class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $authors = Author::search($request->input('keyword', ''))
            ->jsonPaginate();

        return response()->json($authors, ResponseAlias::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AuthorRequest $request
     * @return JsonResponse
     */
    public function store(AuthorRequest $request): JsonResponse
    {
        $author = Author::create($request->only(['name', 'dob', 'description',]));

        return response()->json([
            'message' => 'The Author\'s information has been created',
            'author' => $author
        ], ResponseAlias::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Author $author
     * @return JsonResponse
     */
    public function show(Author $author): JsonResponse
    {
        return response()->json([
            'author' => $author
        ], ResponseAlias::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AuthorRequest $request
     * @param Author $author
     * @return JsonResponse
     */
    public function update(AuthorRequest $request, Author $author): JsonResponse
    {
        $author->update($request->only(['name', 'dob', 'description']));
        return response()->json([
            'message' => 'The Author\'s information has been updated',
            'author' => $author
        ], ResponseAlias::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Author $author
     * @return JsonResponse
     */
    public function destroy(Author $author): JsonResponse
    {
        $author->delete();

        return response()->json([
            'message' => 'The Author\'s information has been deleted',
            'author' => $author
        ], ResponseAlias::HTTP_ACCEPTED);
    }
}
