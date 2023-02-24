<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Http\Requests\CollectionRequest;
use App\Http\Resources\AuthorCollection;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use App\Repositories\AuthorRepository;
use Throwable;


/**
 * @group Author Management
 *
 * API collection to manage authors data.
 *
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 */
class AuthorController extends Controller
{
    /**
     * Author collections
     *
     * Get a list of authors.
     *
     * @queryParam q string Searching keyword of the collection. Example: Eileen
     * @queryParam pageSize int Count of items per page. Allowed size 10, 25, 50, 100. Default 10. Example: 10
     * @queryParam page int Page index to view. Example: 1
     *
     * @bodyParam q string Searching keyword of the collection. Example: Eileen
     * @bodyParam pageSize int Count of items per page. Allowed size 10, 25, 50, 100. Default 10. Example: 10
     *
     * @response 200 {
     * "authors": [
     *      {
     *          "id": 2,
     *          "name": "Eileen Murazik",
     *          "dob": "2019-10-29",
     *          "description": "Qui illo quia molestias natus. Labore maiores tempora harum. Ut dolor doloribus consequatur omnis sit perspiciatis. Nihil dolorem ut nihil impedit.",
     *          "created_at": "2023-02-23T09:43:03.000000Z",
     *          "updated_at": "2023-02-23T09:43:03.000000Z"
     *      }
     *      ],
     *  "links": {
     *      "first": "http://127.0.0.1:8000/api/v1/authors?page=1",
     *      "last": "http://127.0.0.1:8000/api/v1/authors?page=1",
     *      "prev": null,
     *      "next": null
     *  },
     *  "meta": {
     *      "current_page": 1,
     *      "from": 1,
     *      "last_page": 1,
     *      "links": [
     *      {
     *          "url": null,
     *          "label": "&laquo; Previous",
     *          "active": false
     *      },
     *      {
     *          "url": "http://127.0.0.1:8000/api/v1/authors?page=1",
     *          "label": "1",
     *          "active": true
     *      },
     *      {
     *          "url": null,
     *          "label": "Next &raquo;",
     *          "active": false
     *      }
     *  ],
     *  "path": "http://127.0.0.1:8000/api/v1/authors",
     *  "per_page": 10,
     *  "to": 1,
     *  "total": 1
     *  },
     *  "message": "Success to get author collection"
     * }
     * @apiResourceModel App\Models\Author
     *
     * @param CollectionRequest $request
     * @return AuthorCollection
     */
    public function index(CollectionRequest $request): AuthorCollection
    {
        $authors = Author::search($request->q)
            ->paginate(
                $request->input('pageSize', 10)
            );

        return new AuthorCollection($authors);
    }

    /**
     * Store a new author
     *
     * Store a newly created author data in database storage.
     *
     * @bodyParam name string required Name of the author. Example: Robert P.
     * @bodyParam dob date required Author's date of birth with format Y-m-d. Example: 1960-12-23
     * @bodyParam description string Description of the author. Example: this is dummy data
     *
     * @response 201 {
     *      "author": {
     *          "id": 13,
     *          "name": "Robert P.",
     *          "dob": "1960-12-23",
     *          "description": "this is dummy data",
     *          "created_at": "2023-02-24T03:06:51.000000Z",
     *          "updated_at": "2023-02-24T03:06:51.000000Z"
     *      },
     *      "message": "Author has been saved."
     * }
     * @apiResourceModel App\Models\Author
     *
     * @param AuthorRequest $request
     * @param AuthorRepository $repository
     * @return AuthorResource
     * @throws Throwable
     */
    public function store(
        AuthorRequest    $request,
        AuthorRepository $repository
    ): AuthorResource
    {
        $created = $repository->create(
            $request->only(
                [
                    'name',
                    'dob',
                    'description',
                ]
            )
        );

        return new AuthorResource($created, "Author has been saved.");
    }

    /**
     * Show author data
     *
     * Display detail data of the author
     *
     * @urlParam id int required Author ID. Example: 1
     *
     * @apiResource App\Http\Resources\AuthorResource
     * @apiResourceModel App\Models\Author
     *
     * @param Author $author
     * @return AuthorResource
     */
    public function show(
        Author $author
    ): AuthorResource
    {
        return new AuthorResource($author);
    }

    /**
     * Update author data
     *
     * Update the specified author data in database.
     *
     * @urlParam id int required Author ID. Example: 2
     *
     * @bodyParam name string required Name of the author. Example: Robert P.
     * @bodyParam dob date required Author's date of birth with format Y-m-d. Example: 1960-12-23
     * @bodyParam description string Description of the author. Example: This is my new dummy description
     *
     * @response 200 {
     *      "author": {
     *          "id": 2,
     *          "name": "Robert P.",
     *          "dob": "1960-12-23",
     *          "description": "This is my new dummy description",
     *          "created_at": "2023-02-24T03:06:51.000000Z",
     *          "updated_at": "2023-02-24T03:06:51.000000Z"
     *      },
     *      "message": "Author has been saved."
     * }
     * @apiResourceModel App\Models\Author
     *
     * @param AuthorRequest $request
     * @param Author $author
     * @param AuthorRepository $repository
     * @return AuthorResource
     * @throws Throwable
     */
    public function update(
        AuthorRequest    $request,
        Author           $author,
        AuthorRepository $repository
    ): AuthorResource
    {
        $repository->update(
            $author,
            $request->only(
                [
                    'name',
                    'dob',
                    'description',
                ]
            )
        );

        return new AuthorResource($author, "Author has been updated");
    }

    /**
     * Remove author data
     *
     * Remove the specified resource from storage.
     *
     * @urlParam id int required Author ID. Example: 2
     *
     * @response 200 {
     *      "author": {
     *          "id": 2,
     *          "name": "Robert P.",
     *          "dob": "1960-12-23",
     *          "description": "This is my new dummy description",
     *          "created_at": "2023-02-24T03:06:51.000000Z",
     *          "updated_at": "2023-02-24T03:06:51.000000Z"
     *      },
     *      "message": "Author has been deleted."
     * }
     * @apiResourceModel App\Models\Author
     *
     * @param Author $author
     * @param AuthorRepository $repository
     * @return AuthorResource
     * @throws Throwable
     */
    public function destroy(
        Author           $author,
        AuthorRepository $repository
    ): AuthorResource
    {
        $repository->forceDelete($author);

        return new AuthorResource($author, "Author has been deleted");
    }
}
