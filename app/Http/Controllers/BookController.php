<?php

namespace App\Http\Controllers;

use App\Http\Requests\CollectionRequest;
use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Repositories\BookRepository;
use Illuminate\Http\Request;
use Throwable;

/**
 * BookController
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 */
class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CollectionRequest $request
     * @return BookCollection
     */
    public function index(CollectionRequest $request): BookCollection
    {
        $books = Book::search($request->q)
            ->paginate($this->perPageSize($request->pageSize));
        return new BookCollection($books);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param BookRepository $repository
     * @return BookResource
     * @throws Throwable
     */
    public function store(Request $request, BookRepository $repository): BookResource
    {
        $created = $repository->create($request->only([
            'author_id',
            'title',
            'description',
            'price',
            'release_date',
            'image_path',
            'tag_ids',
        ]));

        $created->load(['author', 'tags']);

        return new BookResource($created, "Book has been created");
    }

    /**
     * Display the specified resource.
     *
     * @param Book $book
     * @return BookResource
     */
    public function show(Book $book): BookResource
    {
        $book->load(['author', 'tags']);
        return new BookResource($book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param BookRepository $repository
     * @param Book $book
     * @return BookResource
     * @throws Throwable
     */
    public function update(Request $request, BookRepository $repository, Book $book): BookResource
    {
        $repository->update($book, $request->only([
            'author_id',
            'title',
            'description',
            'price',
            'release_date',
            'image_path',
            'tag_ids',
        ]));
        $book->load(['author', 'tags']);
        
        return new BookResource($book, "Book has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BookRepository $repository
     * @param Book $book
     * @return BookResource
     * @throws Throwable
     */
    public function destroy(BookRepository $repository, Book $book): BookResource
    {
        $repository->forceDelete($book);

        return new BookResource($book, "Book has been deleted");
    }
}
