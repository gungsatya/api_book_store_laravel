<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookCollectionRequest;
use App\Http\Requests\BookRequest;
use App\Http\Requests\CollectionRequest;
use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Repositories\BookRepository;
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
    public function index(BookCollectionRequest $request): BookCollection
    {
        $query = Book::query();

        if ($request->has('q')) {
            $query = $query->search($request->q);
        }

        if ($request->has('tag_ids')) {
            $tag_ids = explode(',', $request->tag_ids);

            foreach ($tag_ids as $key => $tag_id) {
                $tag_ids[$key] = intval($tag_id);
            }

            $query = $query->whereHas('tags', function ($query) use ($tag_ids) {
                $query->whereIn('id', $tag_ids);
            });
        }

        $books = $query->with(['tags'])->paginate(
            $request->input('pageSize', 10)
        );

        return new BookCollection($books);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BookRequest $request
     * @param BookRepository $repository
     * @return BookResource
     * @throws Throwable
     */
    public function store(
        BookRequest    $request,
        BookRepository $repository
    ): BookResource
    {
        $payload = $request->only(
            [
                'author_id',
                'title',
                'description',
                'price',
                'release_date',
                'tag_ids',
            ]
        );

        if ($request->hasFile('cover_image')) {
            $imageName = time() . '.' . $request->cover_image->extension();
            $request
                ->cover_image
                ->move(public_path('cover_images'), $imageName);

            $payload['image_path'] = $imageName;
        }

        $created = $repository->create($payload);
        $created->load(
            [
                'author',
                'tags'
            ]
        );

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
        $book->load(
            [
                'author',
                'tags'
            ]
        );

        return new BookResource($book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BookRequest $request
     * @param BookRepository $repository
     * @param Book $book
     * @return BookResource
     * @throws Throwable
     */
    public function update(
        BookRequest    $request,
        BookRepository $repository,
        Book           $book
    ): BookResource
    {
        $payload = $request->only(
            [
                'author_id',
                'title',
                'description',
                'price',
                'release_date',
                'tag_ids',
            ]
        );

        if ($request->hasFile('cover_image')) {
            $imageName = time() . '.' . $request->cover_image->extension();
            $request
                ->cover_image
                ->move(public_path('cover_images'), $imageName);

            $payload['image_path'] = $imageName;
        }

        $repository->update($book, $payload);

        $book->load(
            [
                'author',
                'tags'
            ]
        );

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
    public function destroy(
        BookRepository $repository,
        Book           $book
    ): BookResource
    {
        $repository->forceDelete($book);

        return new BookResource($book, "Book has been deleted");
    }
}
