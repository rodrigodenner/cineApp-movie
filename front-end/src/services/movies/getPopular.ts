import api from '@/services/client/apiClient.ts'
import type { Movie } from '@/types/Movie'

export const getPopularMovies = (page = 1) => {
  return api.get<{ data: Movie[] }>(`/movies/popular?page=${page}`)
}
