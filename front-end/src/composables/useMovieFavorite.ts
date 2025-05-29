import { ref } from 'vue'
import { favoriteMovie, unfavoriteMovie, getFavoriteMovies } from '@/services/movieService'

export function useMovieFavorite() {
  const isFavorite = ref(false)
  const isLoading = ref(false)

  const toggleFavorite = async (tmdbId: number) => {
    isLoading.value = true
    try {
      if (isFavorite.value) {
        await unfavoriteMovie(tmdbId)
        isFavorite.value = false
      } else {
        await favoriteMovie(tmdbId)
        isFavorite.value = true
      }
    } catch (error) {
      console.error('Erro ao atualizar favoritos', error)
    } finally {
      isLoading.value = false
    }
  }

  const checkIfFavorite = async (tmdbId: number) => {
    try {
      const response = await getFavoriteMovies()
      const favorites = response.data.data
      isFavorite.value = favorites.some((fav: any) => fav.tmdb_id === tmdbId)
    } catch (error) {
      console.warn('Erro ao verificar favorito', error)
      isFavorite.value = false
    }
  }

  return {
    isFavorite,
    isLoading,
    toggleFavorite,
    checkIfFavorite,
  }
}
