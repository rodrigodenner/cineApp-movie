import { ref } from 'vue'
import { favoriteMovie } from '@/services/movieService'

export const useMovieFavorite = () => {
  const isLoading = ref(false)
  const success = ref(false)

  const favorite = async (tmdbId: number) => {
    isLoading.value = true
    success.value = false

    try {
      await favoriteMovie(tmdbId)
      success.value = true
    } catch (error) {
      console.error('Erro ao favoritar filme:', error)
    } finally {
      isLoading.value = false
    }
  }

  return {
    favorite,
    isLoading,
    success,
  }
}
