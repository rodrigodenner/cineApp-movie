<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this['id'],
            'title'        => $this['title'],
            'poster_path'  => $this['poster_path']
                ? rtrim(config('movie-tmdb.tmdb.image_base_url'), '/') . $this['poster_path']
                : null,
            'genres'       => $this['genres'] ?? [],
            'overview'     => $this['overview'],
            'release_date' => $this['release_date'],
            'vote_average' => $this['vote_average'],
            'trailer_url'  => $this['trailer_url'] ?? null,
            'runtime'               => $this['runtime'] ?? null,
            'original_language'     => $this['original_language'] ?? null,
            'budget'                => $this['budget'] ?? null,
            'revenue'               => $this['revenue'] ?? null,
            'production_companies'  => $this['production_companies'] ?? [],
            'production_countries'  => $this['production_countries'] ?? [],
        ];
    }
}
