<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TMDBMovieResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'title' => $this['title'],
            'poster_path' => $this['poster_path'],
            'genres' => $this['genre_ids'] ?? [],
            'overview' => $this['overview'],
            'release_date' => $this['release_date'],
            'vote_average' => $this['vote_average'],
        ];
    }
}

