import api from '@/services/client/apiClient.ts'

export const getGenres = () => {
  return api.get('/movies/genres')
}