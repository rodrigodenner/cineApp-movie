<?php

namespace App\Services\Movie;

use App\Models\MovieFavorite;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ListUserFavoritesService
{
    public function execute(?string $search = null): Collection
    {
        return MovieFavorite::query()
            ->where('user_id', Auth::id())
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%$search%")
                        ->orWhere('overview', 'like', "%$search%")
                        ->orWhereJsonContains('genre_ids', (int) $search)
                        ->orWhereDate('release_date', $search)
                        ->orWhere('vote_average', $search);
                });
            })
            ->get();
    }

}

