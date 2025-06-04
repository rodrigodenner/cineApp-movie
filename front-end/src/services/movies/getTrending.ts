import api from '@/services/client/apiClient.ts'
import type { Movie } from '@/types/Movie'

export const getTrending = (page = 1, period = 'day') => {
  return api.get<{ data: Movie[] }>(`/movies/trending?page=${page}&period=${period}`)
}
