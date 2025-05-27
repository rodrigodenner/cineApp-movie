<?php

namespace App\Services\Movie;

use App\Http\Clients\TMDBClient;

class GetMovieDetailsService
{
    public function __construct(private readonly TMDBClient $client) {}

    public function execute(int $tmdbId): array
    {
        return $this->client->get("movie/{$tmdbId}");
    }
}

