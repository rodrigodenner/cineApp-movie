<?php

namespace App\Services\Movie;

use App\Models\MovieFavorite;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ListUserFavoritesService
{
    public function execute(): Collection
    {
        return MovieFavorite::where('user_id', Auth::id())->get();
    }
}

