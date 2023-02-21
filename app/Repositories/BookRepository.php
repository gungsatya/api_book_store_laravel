<?php

namespace App\Repositories;

use App\Exceptions\GeneralJsonException;
use App\Models\Book;
use DB;
use Illuminate\Database\Eloquent\Model;
use Throwable;

class BookRepository extends BaseRepository
{

    /**
     * @param array $attributes
     * @return Book
     * @throws Throwable
     */
    public function create(array $attributes): Book
    {
        $created = DB::transaction(function () use ($attributes) {
            $created = Book::create([
                'author_id' => data_get($attributes, 'author_id'),
                'title' => data_get($attributes, 'title'),
                'description' => data_get($attributes, 'description'),
                'price' => data_get($attributes, 'price'),
                'release_date' => data_get($attributes, 'release_date'),
                'image_path' => data_get($attributes, 'image_path'),
            ]);

            if (array_key_exists('tag_ids', $attributes)) {
                $created->tags()->sync(data_get($attributes, 'tag_ids'));
            }

            return $created;
        });

        throw_if(!$created, GeneralJsonException::class, 'Failed to create book');

        return $created;
    }

    /**
     * @param Book $model
     * @param array $attributes
     * @return Book
     * @throws Throwable
     */
    public function update(Model $model, array $attributes): Book
    {
        $updated = DB::transaction(function () use ($model, $attributes) {
            $updated = $model->update([
                'author_id' => data_get($attributes, 'author_id', $model->author_id),
                'title' => data_get($attributes, 'title', $model->title),
                'description' => data_get($attributes, 'description', $model->description),
                'price' => data_get($attributes, 'price', $model->price),
                'release_date' => data_get($attributes, 'release_date', $model->release_date),
                'image_path' => data_get($attributes, 'image_path', $model->image_path),
            ]);

            if (array_key_exists('tag_ids', $attributes)) {
                $model->tags()->sync(data_get($attributes, 'tag_ids'));
            }

            return $updated;
        });

        throw_if(!$updated, GeneralJsonException::class, 'Failed to update book');

        return $model;
    }

    /**
     * @param Book $model
     * @throws Throwable
     */
    public function forceDelete(Model $model)
    {
        $deleted = DB::transaction(function () use ($model) {
            return $model->forceDelete();
        });

        throw_if(!$deleted, GeneralJsonException::class, 'Failed to delete book');
    }
}
