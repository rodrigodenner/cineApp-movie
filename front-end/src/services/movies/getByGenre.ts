import api from '@/services/client/apiClient.ts'

export const getMoviesByGenre = (genreId: number, page = 1) => {
  return api.get(`/movies/genre/${genreId}?page=${page}`)
}


