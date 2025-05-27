<?php

namespace App\Rules;

use App\Http\Clients\TMDBClient;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ExistsOnTMDB implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $client = app(TMDBClient::class);

        try {
            $client->get("movie/{$value}");
        } catch (\Throwable) {
            $fail("O {$attribute} não corresponde a um filme válido na TMDB.");
        }
    }
}

