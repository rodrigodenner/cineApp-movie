<?php

namespace App\Services\Movie;

use App\Http\Clients\TMDBClient;

class GetTrendingMoviesService
{
    public function __construct(private readonly TMDBClient $client)
    {
    }

    public function execute(string $period = 'day', int $page = 1): array
    {
        return $this->client->get("trending/movie/{$period}", [
            'page' => $page,
        ]);
    }
}

