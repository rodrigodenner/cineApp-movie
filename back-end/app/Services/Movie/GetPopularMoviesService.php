<?php

namespace App\Services\Movie;

use App\Http\Clients\TMDBClient;

class GetPopularMoviesService
{
    public function __construct(private readonly TMDBClient $client)
    {
    }

    public function execute(int $page = 1): array
    {
        return $this->client->get('movie/popular', ['page' => $page]);
    }

}

