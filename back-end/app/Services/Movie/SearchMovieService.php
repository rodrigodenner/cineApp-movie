<?php

namespace App\Services\Movie;

use App\Http\Clients\TMDBClient;

class SearchMovieService
{
    public function __construct(private readonly TMDBClient $client)
    {
    }

    public function execute(string $query): array
    {
        return $this->client->get('search/movie', [
            'query' => $query,
        ]);
    }
}

