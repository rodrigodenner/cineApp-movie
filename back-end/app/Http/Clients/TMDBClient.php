<?php

namespace App\Http\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class TMDBClient
{
    protected Client $client;
    protected string $token;

    public function __construct()
    {
        $this->token = config('movie-tmdb.tmdb.api_token');

        $this->client = new Client([
            'base_uri' => config('movie-tmdb.tmdb.api_url'),
            'timeout'  => 5.0,
            'headers'  => [
                'Authorization' => 'Bearer ' . $this->token,
                'Accept'        => 'application/json',
            ],
        ]);
    }

    public function get(string $endpoint, array $params = []): array
    {
        $params['language'] = 'pt-BR';

        try {
            $response = $this->client->request('GET', $endpoint, [
                'query' => $params,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            abort($e->getCode() ?: 500, 'Erro ao se comunicar com a API do TMDB');
        }
    }
}

