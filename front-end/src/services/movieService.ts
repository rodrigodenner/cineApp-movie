import axios from 'axios'


export const getNowPlaying = async () => {
  return axios.get(`${import.meta.env.VITE_API_URL}/movies/now-playing`)
}

export const getTrending = async () => {
  return axios.get(`${import.meta.env.VITE_API_URL}/movies/trending`)
}

export const getPopularMovies = async (page = 1) => {
  return axios.get(`${import.meta.env.VITE_API_URL}/movies/popular?page=${page}`)
}


export const getMoviesByGenre = async (genreId: number) => {
  return axios.get(`${import.meta.env.VITE_API_URL}/movies/genre/${genreId}`)
}
