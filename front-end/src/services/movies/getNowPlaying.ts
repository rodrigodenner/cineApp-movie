import api from '@/services/client/apiClient.ts'
import type { Movie } from '@/types/Movie'

export const getNowPlaying = () => {
  return api.get<{ data: Movie[] }>('/movies/now-playing')
}
