<?php

namespace App\DTO;

class MovieDTO
{
    public function __construct(
        public int $tmdb_id,
        public string $title,
        public ?string $poster_path,
        public ?array $genre_ids,
        public ?string $release_date,
        public ?string $overview,
        public ?float $vote_average,
    ) {}

    public static function fromTMDB(array $movie): self
    {
        return new self(
            tmdb_id: $movie['id'],
            title: $movie['title'],
            poster_path: $movie['poster_path'] ?? null,
            genre_ids: collect($movie['genres'])->pluck('id')->toArray(),
            release_date: $movie['release_date'] ?? null,
            overview: $movie['overview'] ?? null,
            vote_average: isset($movie['vote_average']) ? (float) $movie['vote_average'] : null,
        );
    }

    public function toArray(): array
    {
        return [
            'tmdb_id'      => $this->tmdb_id,
            'title'        => $this->title,
            'poster_path'  => $this->poster_path,
            'genre_ids'    => $this->genre_ids,
            'release_date' => $this->release_date,
            'overview'     => $this->overview,
            'vote_average' => $this->vote_average,
        ];
    }
}
