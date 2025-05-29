<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\Movie\GenreMapperService;

class TMDBMovieResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this['id'],
            'title'        => $this['title'],
            'poster_path'  => $this['poster_path']
                ? rtrim(config('movie-tmdb.tmdb.image_base_url'), '/') . $this['poster_path']
                : null,
            'genres'       => $this->mapGenres(),
            'overview'     => $this['overview'],
            'release_date' => $this['release_date'],
            'vote_average' => $this['vote_average'],
        ];
    }

    protected function mapGenres(): array
    {
        if (isset($this['genres']) && is_array($this['genres'])) {
            return collect($this['genres'])
                ->pluck('name')
                ->filter()
                ->values()
                ->toArray();
        }
        return GenreMapperService::map($this['genre_ids'] ?? []);
    }
}
