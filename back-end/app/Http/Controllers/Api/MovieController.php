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
     *     @OA\Parameter(name="query", in="query", required=true, description="Texto para busca no título do filme", @OA\Schema(type="string")),
     *     @OA\Parameter(name="page", in="query", required=false, description="Número da página", @OA\Schema(type="integer", default=1)),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de filmes",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/TMDBMovie")),
     *             @OA\Property(property="meta", type="object",
     *                 @OA\Property(property="page", type="integer", example=1),
     *                 @OA\Property(property="total_results", type="integer", example=10000),
     *                 @OA\Property(property="total_pages", type="integer", example=500),
     *                 @OA\Property(property="query", type="string", example="batman")
     *             )
     *         )
     *     )
     * )
     */
    public function search(Request $request, SearchMovieService $service)
    {
        $query = $request->query('query');
        $page = $request->query('page', 1);
        $movies = $service->execute($query, (int) $page);
        return response()->json([
            'data' => TMDBMovieResource::collection($movies['results'] ?? []),
            'meta' => [
                'page' => $movies['page'] ?? 1,
                'total_results' => $movies['total_results'] ?? null,
                'total_pages' => $movies['total_pages'] ?? null,
                'query' => $query,
            ],
        ]);
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
     *     @OA\Parameter(name="page", in="query", required=false, description="Número da página", @OA\Schema(type="integer", default=1)),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de filmes",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/TMDBMovie")),
     *             @OA\Property(property="meta", type="object",
     *                 @OA\Property(property="page", type="integer", example=1),
     *                 @OA\Property(property="total_results", type="integer", example=10000),
     *                 @OA\Property(property="total_pages", type="integer", example=500)
     *             )
     *         )
     *     )
     * )
     */
    public function popular(Request $request, GetPopularMoviesService $service)
    {
        $page = $request->query('page', 1);
        $movies = $service->execute((int)$page);
        return response()->json([
            'data' => TMDBMovieResource::collection($movies['results'] ?? []),
            'meta' => [
                'page' => $movies['page'] ?? 1,
                'total_results' => $movies['total_results'] ?? null,
                'total_pages' => $movies['total_pages'] ?? null,
            ],
        ]);
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
     *     @OA\Parameter(name="period", in="query", required=false, description="Período da tendência (day ou week)", @OA\Schema(type="string", enum={"day", "week"}, default="day")),
     *     @OA\Parameter(name="page", in="query", required=false, description="Número da página", @OA\Schema(type="integer", default=1)),
     *     @OA\Response(
     *         response=200,
     *         description="Filmes em alta",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/TMDBMovie")),
     *             @OA\Property(property="meta", type="object",
     *                 @OA\Property(property="page", type="integer", example=1),
     *                 @OA\Property(property="total_results", type="integer", example=10000),
     *                 @OA\Property(property="total_pages", type="integer", example=500),
     *                 @OA\Property(property="period", type="string", example="day")
     *             )
     *         )
     *     )
     * )
     */
    public function trending(Request $request, GetTrendingMoviesService $service)
    {
        $page = $request->query('page', 1);
        $period = $request->query('period', 'day');
        $movies = $service->execute($period, (int)$page);

        return response()->json([
            'data' => TMDBMovieResource::collection($movies['results'] ?? []),
            'meta' => [
                'page' => $movies['page'] ?? 1,
                'total_results' => $movies['total_results'] ?? null,
                'total_pages' => $movies['total_pages'] ?? null,
                'period' => $period,
            ],
        ]);
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
     *     @OA\Parameter(name="page", in="query", required=false, description="Número da página", @OA\Schema(type="integer", default=1)),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de filmes",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/TMDBMovie")),
     *             @OA\Property(property="meta", type="object",
     *                 @OA\Property(property="page", type="integer", example=1),
     *                 @OA\Property(property="total_results", type="integer", example=10000),
     *                 @OA\Property(property="total_pages", type="integer", example=500),
     *                 @OA\Property(property="genre_id", type="integer", example=35)
     *             )
     *         )
     *     )
     * )
     */
    public function byGenre(Request $request, int $genreId, GetMoviesByGenreService $service)
    {
        $page = $request->query('page', 1);
        $movies = $service->execute($genreId, (int)$page);
        return response()->json([
            'data' => TMDBMovieResource::collection($movies['results'] ?? []),
            'meta' => [
                'page' => $movies['page'] ?? 1,
                'total_results' => $movies['total_results'] ?? null,
                'total_pages' => $movies['total_pages'] ?? null,
                'genre_id' => $genreId,
            ],
        ]);
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
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         required=false,
     *         description="Busca flexível por título, sinopse, nota, gênero ou data",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Favoritos", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/MovieFavorite")))
     * )
     */
    public function getFavorites(Request $request, ListUserFavoritesService $service)
    {
        $search = $request->get('search');
        $movies = $service->execute($search);
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
