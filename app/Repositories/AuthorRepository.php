<?php

namespace App\Repositories;

use App\Exceptions\GeneralJsonException;
use App\Models\Author;
use DB;
use Throwable;

class AuthorRepository extends BaseRepository
{

    /**
     * @param $attributes
     * @return Author
     * @throws Throwable
     */
    public function create($attributes): mixed
    {
        $created = DB::transaction(function () use ($attributes) {
            return Author::create([
                'name' => data_get($attributes, 'name'),
                'dob' => data_get($attributes, 'dob'),
                'description' => data_get($attributes, 'description'),
            ]);
        });

        throw_if(!$created, GeneralJsonException::class, 'Failed to create author');

        return $created;
    }

    /**
     * @param Author $model
     * @param $attributes
     * @return Author
     * @throws Throwable
     */
    public function update($model, $attributes): Author
    {
        $updated = DB::transaction(function () use ($model, $attributes) {
            return $model->update([
                'name' => data_get($attributes, 'name'),
                'dob' => data_get($attributes, 'dob'),
                'description' => data_get($attributes, 'description'),
            ]);
        });

        throw_if(!$updated, GeneralJsonException::class, 'Failed to update author');

        return $model;
    }

    /**
     * @throws Throwable
     */
    public function forceDelete($model)
    {
        $deleted = DB::transaction(function () use ($model) {
            return $model->forceDelete();
        });

        throw_if(!$deleted, GeneralJsonException::class, 'Failed to delete author');
    }
}
