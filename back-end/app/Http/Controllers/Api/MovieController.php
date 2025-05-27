<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Movie\FavoriteMovieRequest;
use App\Http\Resources\MovieResource;
use App\Http\Resources\TMDBMovieResource;
use App\Services\Movie\FavoriteMovieService;
use App\Services\Movie\GetGenresService;
use App\Services\Movie\GetMovieDetailsService;
use App\Services\Movie\GetMoviesByGenreService;
use App\Services\Movie\GetNowPlayingMoviesService;
use App\Services\Movie\GetPopularMoviesService;
use App\Services\Movie\GetTrendingMoviesService;
use App\Services\Movie\ListUserFavoritesService;
use App\Services\Movie\SearchMovieService;
use App\Services\Movie\UnfavoriteMovieService;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="TMDBMovie",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=550),
 *     @OA\Property(property="title", type="string", example="Fight Club"),
 *     @OA\Property(property="poster_path", type="string", example="/a26cQPRhJPX6GbWfQbvZdrrp9j9.jpg"),
 *     @OA\Property(property="genres", type="array", @OA\Items(type="integer"), example={18, 28}),
 *     @OA\Property(property="overview", type="string", example="Um homem insatisfeito com sua vida conhece Tyler..."),
 *     @OA\Property(property="release_date", type="string", format="date", example="1999-10-15"),
 *     @OA\Property(property="vote_average", type="number", format="float", example=8.4)
 * )
 *
 * @OA\Schema(
 *     schema="MovieFavorite",
 *     type="object",
 *     @OA\Property(property="tmdb_id", type="integer", example=550),
 *     @OA\Property(property="title", type="string", example="Fight Club"),
 *     @OA\Property(property="poster_path", type="string", example="/a26cQPRhJPX6GbWfQbvZdrrp9j9.jpg"),
 *     @OA\Property(property="genre_ids", type="array", @OA\Items(type="integer"), example={18, 28}),
 *     @OA\Property(property="release_date", type="string", format="date", example="1999-10-15"),
 *     @OA\Property(property="overview", type="string", example="Um homem insatisfeito com sua vida conhece Tyler..."),
 *     @OA\Property(property="vote_average", type="number", format="float", example=8.4)
 * )
 */
class MovieController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/movies/search",
     *     tags={"Movies"},
     *     summary="Buscar filmes por nome",
     *     security={{"Bearer":{}}},
     *     @OA\Parameter(name="query", in="query", required=true, @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Lista de filmes", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/TMDBMovie")))
     * )
     */
    public function search(Request $request, SearchMovieService $service)
    {
        $movies = $service->execute($request->query('query'));
        return TMDBMovieResource::collection($movies['results'] ?? []);
    }

    /**
     * @OA\Get(
     *     path="/api/movies/{id}",
     *     tags={"Movies"},
     *     summary="Detalhes de um filme",
     *     security={{"Bearer":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Detalhes do filme", @OA\JsonContent(ref="#/components/schemas/TMDBMovie"))
     * )
     */
    public function show(int $id, GetMovieDetailsService $service)
    {
        $movie = $service->execute($id);
        return new TMDBMovieResource($movie);
    }

    /**
     * @OA\Get(
     *     path="/api/movies/popular",
     *     tags={"Movies"},
     *     summary="Listar filmes populares",
     *     security={{"Bearer":{}}},
     *     @OA\Response(response=200, description="Lista de filmes", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/TMDBMovie")))
     * )
     */
    public function popular(GetPopularMoviesService $service)
    {
        $movies = $service->execute();
        return TMDBMovieResource::collection($movies['results'] ?? []);
    }

    /**
     * @OA\Get(
     *     path="/api/movies/now-playing",
     *     tags={"Movies"},
     *     summary="Listar filmes em cartaz",
     *     security={{"Bearer":{}}},
     *     @OA\Response(response=200, description="Filmes em cartaz", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/TMDBMovie")))
     * )
     */
    public function nowPlaying(GetNowPlayingMoviesService $service)
    {
        $movies = $service->execute();
        return TMDBMovieResource::collection($movies['results'] ?? []);
    }

    /**
     * @OA\Get(
     *     path="/api/movies/trending",
     *     tags={"Movies"},
     *     summary="Filmes em alta",
     *     security={{"Bearer":{}}},
     *     @OA\Response(response=200, description="Filmes em alta", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/TMDBMovie")))
     * )
     */
    public function trending(GetTrendingMoviesService $service)
    {
        $movies = $service->execute();
        return TMDBMovieResource::collection($movies['results'] ?? []);
    }

    /**
     * @OA\Get(
     *     path="/api/movies/genres",
     *     tags={"Movies"},
     *     summary="Listar todos os gêneros",
     *     security={{"Bearer":{}}},
     *     @OA\Response(response=200, description="Lista de gêneros", @OA\JsonContent(type="array", @OA\Items(type="object", @OA\Property(property="id", type="integer"), @OA\Property(property="name", type="string"))))
     * )
     */
    public function genres(GetGenresService $service)
    {
        $genres = $service->execute();
        return response()->json(['data' => $genres['genres'] ?? []]);
    }

    /**
     * @OA\Get(
     *     path="/api/movies/genre/{genreId}",
     *     tags={"Movies"},
     *     summary="Filmes por gênero",
     *     security={{"Bearer":{}}},
     *     @OA\Parameter(name="genreId", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Lista de filmes", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/TMDBMovie")))
     * )
     */
    public function byGenre(int $genreId, GetMoviesByGenreService $service)
    {
        $movies = $service->execute($genreId);
        return TMDBMovieResource::collection($movies['results'] ?? []);
    }

    /**
     * @OA\Post(
     *     path="/api/movies/favorite",
     *     tags={"Movies"},
     *     summary="Favoritar um filme",
     *     security={{"Bearer":{}}},
     *     @OA\RequestBody(required=true, @OA\JsonContent(required={"tmdb_id"}, @OA\Property(property="tmdb_id", type="integer", example=550))),
     *     @OA\Response(response=201, description="Filme favoritado", @OA\JsonContent(ref="#/components/schemas/MovieFavorite"))
     * )
     */
    public function favorite(FavoriteMovieRequest $request, FavoriteMovieService $service)
    {
        $favorite = $service->execute($request->integer('tmdb_id'));
        return new MovieResource($favorite);
    }

    /**
     * @OA\Get(
     *     path="/api/movies/favorites",
     *     tags={"Movies"},
     *     summary="Listar filmes favoritos",
     *     security={{"Bearer":{}}},
     *     @OA\Response(response=200, description="Favoritos", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/MovieFavorite")))
     * )
     */
    public function getFavorites(ListUserFavoritesService $service)
    {
        $movies = $service->execute();
        return MovieResource::collection($movies);
    }

    /**
     * @OA\Delete(
     *     path="/api/movies/favorites/{tmdbId}",
     *     tags={"Movies"},
     *     summary="Remover dos favoritos",
     *     security={{"Bearer":{}}},
     *     @OA\Parameter(name="tmdbId", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Removido", @OA\JsonContent(@OA\Property(property="message", type="string", example="Removido dos favoritos")))
     * )
     */
    public function unfavorite(int $tmdbId, UnfavoriteMovieService $service)
    {
        $service->execute($tmdbId);
        return response()->json(['message' => 'Removido dos favoritos']);
    }
}
