<?php

namespace App\Services\Movie;

use App\Http\Clients\TMDBClient;

class GetMovieDetailsService
{
    public function __construct(private readonly TMDBClient $client)
    {
    }

    public function execute(int $tmdbId): array
    {
        $movie = $this->client->get("movie/{$tmdbId}");
        $trailerUrl = $this->getYoutubeTrailerUrl($tmdbId);

        return [
            ...$movie,
            'trailer_url' => $trailerUrl,
        ];
    }

    private function getYoutubeTrailerUrl(int $tmdbId): ?string
    {
        $videos = $this->client->get("movie/{$tmdbId}/videos");

        $trailer = collect($videos['results'] ?? [])
            ->first(fn($video) => $video['type'] === 'Trailer' && $video['site'] === 'YouTube');

        return $trailer ? "https://www.youtube.com/watch?v={$trailer['key']}" : null;
    }


}

