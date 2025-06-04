import api from '@/services/client/apiClient.ts'

export const getFavoriteMovies = (search?: string) => {
  const query = search ? `?search=${encodeURIComponent(search)}` : ''
  return api.get(`/movies/favorites${query}`)
}