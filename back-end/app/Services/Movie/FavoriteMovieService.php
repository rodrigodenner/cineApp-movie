<?php

namespace App\Services\Movie;

use App\DTO\MovieDTO;
use App\Http\Clients\TMDBClient;
use App\Models\MovieFavorite;
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
        $dto = MovieDTO::fromTMDB($movie);

        return MovieFavorite::create([
            'user_id' => $userId,
            ...$dto->toArray(),
        ]);
    }
}
