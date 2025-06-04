import api from '@/services/client/apiClient.ts'

export const favoriteMovie = (tmdbId: number) => {
  return api.post('/movies/favorite', { tmdb_id: tmdbId })
}