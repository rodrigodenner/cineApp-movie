<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovieFavorite extends Model
{
    protected $fillable = ['user_id', 'tmdb_id', 'title', 'poster_path', 'genre_ids'];

    protected $casts = [
        'genre_ids' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
