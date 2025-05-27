<?php

namespace App\Http\Requests\Movie;

use App\Rules\ExistsOnTMDB;
use Illuminate\Foundation\Http\FormRequest;

class FavoriteMovieRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'tmdb_id' => ['required', 'integer', new ExistsOnTMDB],
        ];
    }
}



