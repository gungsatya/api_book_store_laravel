<?php

namespace App\Models;

use Database\Factories\AuthorFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Author
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $dob
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Book> $books
 * @property-read int|null $books_count
 * @method static AuthorFactory factory($count = null, $state = [])
 * @method static Builder|Author newModelQuery()
 * @method static Builder|Author newQuery()
 * @method static Builder|Author query()
 * @method static Builder|Author search(string $keyword)
 * @method static Builder|Author whereCreatedAt($value)
 * @method static Builder|Author whereDescription($value)
 * @method static Builder|Author whereDob($value)
 * @method static Builder|Author whereId($value)
 * @method static Builder|Author whereName($value)
 * @method static Builder|Author whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'dob',
        'description'
    ];

    protected $casts = [
        'dob' => 'date:Y-m-d'
    ];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    /**
     * Scope a query to only include users of a given type.
     *
     * @param Builder $query
     * @param string|null $keyword
     * @return Builder
     */
    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        if ($keyword != null) {
            $query = $query->where(
                'name',
                'like',
                "%$keyword%"
            );
        }

        return $query;
    }
}
