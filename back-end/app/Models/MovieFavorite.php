<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovieFavorite extends Model
{
    protected $fillable = [
        'user_id',
        'tmdb_id',
        'title',
        'poster_path',
        'genre_ids',
        'release_date',
        'overview',
        'vote_average',
    ];

    protected $casts = [
        'genre_ids' => 'array',
        'release_date' => 'date',
        'vote_average' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
