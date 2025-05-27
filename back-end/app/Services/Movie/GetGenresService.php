<?php

namespace App\Services\Movie;

use App\Http\Clients\TMDBClient;

class GetGenresService
{
    public function __construct(private readonly TMDBClient $client)
    {
    }

    public function execute(): array
    {
        return $this->client->get('genre/movie/list');
    }
}
