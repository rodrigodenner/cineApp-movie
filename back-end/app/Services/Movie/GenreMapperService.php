<?php

namespace App\Services\Movie;

use App\Http\Clients\TMDBClient;
use Illuminate\Support\Facades\Cache;

class GenreMapperService
{
    public static function map(array $ids): array
    {
        $genres = self::getGenres();

        return collect($ids)
            ->map(fn($id) => $genres[$id] ?? null)
            ->filter()
            ->values()
            ->toArray();
    }

    protected static function getGenres(): array
    {
        return Cache::rememberForever('tmdb_genres', function () {
            $client = new TMDBClient();
            $response = $client->get('genre/movie/list');
            return collect($response['genres'])->pluck('name', 'id')->toArray();
        });
    }
}
