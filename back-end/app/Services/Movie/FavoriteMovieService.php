<?php

namespace App\Services\Movie;

use App\Models\MovieFavorite;
use App\Http\Clients\TMDBClient;
use Illuminate\Support\Facades\Auth;

class FavoriteMovieService
{
    public function __construct(private readonly TMDBClient $client) {}

    public function execute(int $tmdbId): MovieFavorite
    {
        $userId = Auth::id();

        $exists = MovieFavorite::where('user_id', $userId)
            ->where('tmdb_id', $tmdbId)
            ->exists();

        if ($exists) {
            abort(409, 'Filme já favoritado');
        }

        $movie = $this->client->get("movie/{$tmdbId}");

        return MovieFavorite::create([
            'user_id'      => $userId,
            'tmdb_id'      => $movie['id'],
            'title'        => $movie['title'],
            'poster_path'  => $movie['poster_path'] ?? null,
            'genre_ids'    => collect($movie['genres'])->pluck('id')->toArray(),
            'release_date' => $movie['release_date'] ?? null,
            'overview'     => $movie['overview'] ?? null,
            'vote_average' => $movie['vote_average'] ?? null,
        ]);
    }
}



