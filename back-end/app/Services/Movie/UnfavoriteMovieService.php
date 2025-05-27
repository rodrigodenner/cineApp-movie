<?php

namespace App\Services\Movie;

use App\Models\MovieFavorite;
use Illuminate\Support\Facades\Auth;

class UnfavoriteMovieService
{
    public function execute(int $tmdbId): void
    {
        $deleted = MovieFavorite::where('user_id', Auth::id())
            ->where('tmdb_id', $tmdbId)
            ->delete();

        if (!$deleted) {
            abort(404, 'Filme não encontrado na lista de favoritos');
        }
    }
}

