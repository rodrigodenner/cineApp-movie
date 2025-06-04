import api from '@/services/client/apiClient.ts'

export const getMovieDetails = (id: number) => {
  return api.get(`/movies/${id}`)
}