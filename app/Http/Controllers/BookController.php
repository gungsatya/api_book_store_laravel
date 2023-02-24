<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookCollectionRequest;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Repositories\BookRepository;
use Throwable;

/**
 * @group Book Management
 *
 * API collection to manage books data.
 *
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 */
class BookController extends Controller
{
    /**
     * Book Collections
     *
     * Get book list
     *
     * @queryParam tag_ids string IDs of tag in search. Example: 1,2
     * @queryParam q string Searching keyword of the collection. Example: Harry Potter
     * @queryParam pageSize int Count of items per page. Allowed size 10, 25, 50, 100. Default 10. Example: 10
     * @queryParam page int Page index to view. Example: 1
     *
     * @bodyParam tag_ids string IDs of tag in search. Example: 1,2
     * @bodyParam q string Searching keyword of the collection. Example: Harry Potter
     * @bodyParam pageSize int Count of items per page. Allowed size 10, 25, 50, 100. Default 10. Example: 10
     *
     * @response 200 {
     *      "books": [
     *          {
     *              "id": 13,
     *              "title": "Harry Potter",
     *              "description": "This harry potter description",
     *              "price": 150000,
     *              "release_date": "2023-12-23T00:00:00.000000Z",
     *              "image_path": null,
     *              "tags": [
     *                  {
     *                      "id": 1,
     *                      "name": "Dictionary"
     *                  },
     *                  {
     *                      "id": 2,
     *                      "name": "Novel"
     *                  }
     *              ],
     *              "created_at": "2023-02-24T05:28:13.000000Z",
     *              "updated_at": "2023-02-24T05:28:13.000000Z"
     *          }
     *      ],
     *      "links": {
     *          "first": "http://127.0.0.1:8000/api/v1/books?page=1",
     *          "last": "http://127.0.0.1:8000/api/v1/books?page=1",
     *          "prev": null,
     *          "next": null
     *      },
     *      "meta": {
     *          "current_page": 1,
     *          "from": 1,
     *          "last_page": 1,
     *          "links": [
     *              {
     *                  "url": null,
     *                  "label": "&laquo; Previous",
     *                  "active": false
     *              },
     *              {
     *                  "url": "http://127.0.0.1:8000/api/v1/books?page=1",
     *                  "label": "1",
     *                  "active": true
     *              },
     *              {
     *                  "url": null,
     *                  "label": "Next &raquo;",
     *                  "active": false
     *              }
     *          ],
     *          "path": "http://127.0.0.1:8000/api/v1/books",
     *          "per_page": 10,
     *          "to": 1,
     *          "total": 1
     *          },
     *      "message": "Success to get book collection"
     * }
     * @apiResourceModel App\Models\Book
     *
     * @param BookCollectionRequest $request
     * @return BookCollection
     */
    public function index(BookCollectionRequest $request): BookCollection
    {
        $books = Book::search($request->q)
            ->inTag($request->tag_ids)
            ->with(['tags'])
            ->paginate(
                $request->input('pageSize', 10)
            );

        return new BookCollection($books);
    }

    /**
     * Store new book data
     *
     * Store a newly created book data in database.
     *
     * @bodyParam author_id int required Book's Author. Example: 1
     * @bodyParam title string required Book's title. Example: Harry Potter
     * @bodyParam price double required Book's price. Example: 150000
     * @bodyParam release_date date required Book's released date with format Y-m-d. Example: 1960-12-23
     * @bodyParam description string Description of the book. Example: This harry potter description
     * @bodyParam cover_image file Book's cover image
     * @bodyParam tag_ids int[] Tag ids
     *
     * @response 201 {
     *      {
     *          "book": {
     *              "id": 13,
     *              "title": "Harry Potter",
     *              "description": "This harry potter description",
     *              "price": 150000,
     *              "release_date": "2023-12-23T00:00:00.000000Z",
     *              "image_path": null,
     *              "author": {
     *                  "id": 1,
     *                  "name": "Dr. Verlie Waelchi V",
     *                  "dob": "1984-01-07",
     *                  "description": "Quas et sed sit est expedita dolores. Voluptatem et iste et aspernatur est dolore in. Iure nesciunt voluptate quia voluptatem. Excepturi soluta qui rerum dicta et dolorem.",
     *                  "created_at": "2023-02-24T05:27:46.000000Z",
     *                  "updated_at": "2023-02-24T05:27:46.000000Z"
     *              },
     *              "tags": [
     *                  {
     *                      "id": 1,
     *                      "name": "Dictionary"
     *                  },
     *                  {
     *                      "id": 2,
     *                      "name": "Novel"
     *                  }
     *              ],
     *              "created_at": "2023-02-24T05:28:13.000000Z",
     *              "updated_at": "2023-02-24T05:28:13.000000Z"
     *          },
     *          "message": "Book has been created"
     *          }
     * }
     * @apiResourceModel App\Models\Book
     *
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
     * Show book data
     *
     * Display detail data of the author
     *
     * @urlParam id int required Book ID. Example: 1
     *
     * @apiResource App\Http\Resources\BookResource
     * @apiResourceModel App\Models\Book
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
     * Update book data
     *
     * Update the specified author data in database.
     *
     * @urlParam id int required Book ID. Example: 13
     *
     * @bodyParam author_id int required Book's Author. Example: 1
     * @bodyParam title string required Book's title. Example: Harry Potter
     * @bodyParam price double required Book's price. Example: 150000
     * @bodyParam release_date date required Book's released date with format Y-m-d. Example: 1960-12-23
     * @bodyParam description string Description of the book. Example: This harry potter description
     * @bodyParam cover_image file Book's cover image
     * @bodyParam tag_ids int[] Tag ids
     *
     * @response 200 {
     *      {
     *          "book": {
     *              "id": 13,
     *              "title": "Harry Potter",
     *              "description": "This harry potter description",
     *              "price": 150000,
     *              "release_date": "2023-12-23T00:00:00.000000Z",
     *              "image_path": null,
     *              "author": {
     *                  "id": 1,
     *                  "name": "Dr. Verlie Waelchi V",
     *                  "dob": "1984-01-07",
     *                  "description": "Quas et sed sit est expedita dolores. Voluptatem et iste et aspernatur est dolore in. Iure nesciunt voluptate quia voluptatem. Excepturi soluta qui rerum dicta et dolorem.",
     *                  "created_at": "2023-02-24T05:27:46.000000Z",
     *                  "updated_at": "2023-02-24T05:27:46.000000Z"
     *              },
     *              "tags": [
     *                  {
     *                      "id": 1,
     *                      "name": "Dictionary"
     *                  },
     *                  {
     *                      "id": 2,
     *                      "name": "Novel"
     *                  }
     *              ],
     *              "created_at": "2023-02-24T05:28:13.000000Z",
     *              "updated_at": "2023-02-24T05:28:13.000000Z"
     *          },
     *          "message": "Book has been updated"
     *      }
     * }
     * @apiResourceModel App\Models\Book
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
     * Remove book data
     *
     * Remove the specified book from database.
     *
     * @urlParam id int required Book ID. Example: 13
     *
     * @response 200 {
     *      "author": {
     *              "id": 13,
     *              "title": "Harry Potter",
     *              "description": "This harry potter description",
     *              "price": 150000,
     *              "release_date": "2023-12-23T00:00:00.000000Z",
     *              "image_path": null,
     *              "author": {
     *                  "id": 1,
     *                  "name": "Dr. Verlie Waelchi V",
     *                  "dob": "1984-01-07",
     *                  "description": "Quas et sed sit est expedita dolores. Voluptatem et iste et aspernatur est dolore in. Iure nesciunt voluptate quia voluptatem. Excepturi soluta qui rerum dicta et dolorem.",
     *                  "created_at": "2023-02-24T05:27:46.000000Z",
     *                  "updated_at": "2023-02-24T05:27:46.000000Z"
     *              },
     *              "tags": [
     *                  {
     *                      "id": 1,
     *                      "name": "Dictionary"
     *                  },
     *                  {
     *                      "id": 2,
     *                      "name": "Novel"
     *                  }
     *              ],
     *              "created_at": "2023-02-24T05:28:13.000000Z",
     *              "updated_at": "2023-02-24T05:28:13.000000Z"
     *      },
     *      "message": "Book has been deleted"
     *  }
     * @apiResourceModel App\Models\Book
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
