<?php

namespace App\Repositories;

use App\Exceptions\GeneralJsonException;
use App\Models\Tag;
use DB;
use Illuminate\Database\Eloquent\Model;
use Throwable;

class TagRepository extends BaseRepository
{

    /**
     * @throws Throwable
     */
    public function create(array $attributes)
    {
        $created = DB::transaction(function () use ($attributes) {
            return Tag::create([
                'name' => data_get($attributes, 'name'),
            ]);
        });

        throw_if(!$created, GeneralJsonException::class, 'Failed to create tag');

        return $created;
    }

    /**
     * @throws GeneralJsonException
     */
    public function update(Model $model, array $attributes)
    {
        throw new GeneralJsonException('Cannot update tag');
    }

    /**
     * @throws Throwable
     */
    public function forceDelete(Model $model)
    {
        $deleted = DB::transaction(function () use ($model) {
            return $model->forceDelete();
        });

        throw_if(!$deleted, GeneralJsonException::class, 'Failed to delete tag');
    }
}
