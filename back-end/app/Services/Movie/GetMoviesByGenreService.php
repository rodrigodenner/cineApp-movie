<?php

namespace App\Services\Movie;

use App\Http\Clients\TMDBClient;

class GetMoviesByGenreService
{
    public function __construct(private readonly TMDBClient $client)
    {
    }

    public function execute(int $genreId, int $page = 1): array
    {
        return $this->client->get('discover/movie', [
            'with_genres' => $genreId,
            'page' => $page,
        ]);
    }

}

