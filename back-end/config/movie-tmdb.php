<?php

return [
    'tmdb' => [
        'api_key'   => env('TMDB_API_KEY'),
        'api_token' => env('TMDB_API_TOKEN'),
        'api_url'   => env('TMDB_API_URL'),
        'image_base_url'  => env('TMDB_IMAGE_BASE_URL', 'https://image.tmdb.org/t/p/w500'),
    ],
];

