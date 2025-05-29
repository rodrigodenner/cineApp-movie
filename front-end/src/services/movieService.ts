import axios from 'axios'
import api from "@/services/authService.ts";

export const getNowPlaying = async () => {
  return axios.get(`${import.meta.env.VITE_API_URL}/movies/now-playing`)
}

export const getTrending = async (page = 1) => {
  return axios.get(`${import.meta.env.VITE_API_URL}/movies/trending?page=${page}`)
}

export const getPopularMovies = async (page = 1) => {
  return axios.get(`${import.meta.env.VITE_API_URL}/movies/popular?page=${page}`)
}

export const getMoviesByGenre = async (genreId: number, page = 1) => {
  return axios.get(`${import.meta.env.VITE_API_URL}/movies/genre/${genreId}?page=${page}`)
}

export const getMovieDetails = async (id: number) => {
  return axios.get(`${import.meta.env.VITE_API_URL}/movies/${id}`)
}

export const getMoviesBySearch = async (query: string, page = 1) => {
  return axios.get(`${import.meta.env.VITE_API_URL}/movies/search?query=${query}&page=${page}`)
}


export const favoriteMovie = async (tmdbId: number) => {
  return api.post('/movies/favorite', { tmdb_id: tmdbId })
}

export const unfavoriteMovie = async (tmdbId: number) => {
  return api.delete(`/movies/favorites/${tmdbId}`)
}

export const getFavoriteMovies = async (search?: string) => {
  const query = search ? `?search=${encodeURIComponent(search)}` : ''
  return api.get(`/movies/favorites${query}`)
}

