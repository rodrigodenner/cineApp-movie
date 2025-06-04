import api from '@/services/client/apiClient.ts'
import type { Movie } from '@/types/Movie'

export const getMoviesBySearch = (query: string, page = 1) => {
  return api.get<{ data: Movie[] }>(`/movies/search?query=${encodeURIComponent(query)}&page=${page}`)
}
