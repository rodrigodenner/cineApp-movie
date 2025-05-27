<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'tmdb_id' => $this->tmdb_id,
            'title' => $this->title,
            'poster_path' => $this->poster_path,
            'genre_ids' => $this->genre_ids,
            'release_date' => $this->release_date,
            'overview' => $this->overview,
            'vote_average' => $this->vote_average,
        ];
    }
}
