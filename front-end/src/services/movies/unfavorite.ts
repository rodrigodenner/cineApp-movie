import api from '@/services/client/apiClient.ts'

export const unfavoriteMovie = (tmdbId: number) => {
  return api.delete(`/movies/favorites/${tmdbId}`)
}