<?php

namespace App\Models;

use Database\Factories\BookFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;


/**
 * App\Models\Book
 *
 * @property int $id
 * @property int|null $author_id
 * @property string $title
 * @property string|null $description
 * @property float $price
 * @property Carbon|null $release_date
 * @property string|null $image_path
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Author|null $author
 * @property-read Collection<int, Tag> $tags
 * @property-read int|null $tags_count
 * @method static BookFactory factory($count = null, $state = [])
 * @method static Builder|Book newModelQuery()
 * @method static Builder|Book newQuery()
 * @method static Builder|Book query()
 * @method static Builder|Book search(string $keyword)
 * @method static Builder|Book whereAuthorId($value)
 * @method static Builder|Book whereCreatedAt($value)
 * @method static Builder|Book whereDescription($value)
 * @method static Builder|Book whereId($value)
 * @method static Builder|Book whereImagePath($value)
 * @method static Builder|Book wherePrice($value)
 * @method static Builder|Book whereReleaseDate($value)
 * @method static Builder|Book whereTitle($value)
 * @method static Builder|Book whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'title',
        'description',
        'price',
        'release_date',
        'image_path',
    ];

    protected $casts = [
        'price' => 'double',
        'release_date' => 'date:Y-m-d'
    ];

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
                'title',
                'like',
                "%{$keyword}%"
            );
        }

        return $query;
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
