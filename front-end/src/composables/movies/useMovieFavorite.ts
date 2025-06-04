import { ref } from 'vue'
import { unfavoriteMovie } from '@/services/movies/unfavorite'
import { favoriteMovie } from '@/services/movies/favorite'
import { getFavoriteMovies } from '@/services/movies/getFavorites'
import { handleError } from '@/utils/handleError'
import type {FavoriteMovie} from "@/types/FavoriteMovie.ts";


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
      handleError(error, 'Erro ao atualizar favoritos')
    } finally {
      isLoading.value = false
    }
  }

  const checkIfFavorite = async (tmdbId: number) => {
    try {
      const response = await getFavoriteMovies()
      const favorites: FavoriteMovie[] = response.data.data
      isFavorite.value = favorites.some((fav) => fav.tmdb_id === tmdbId)
    } catch (error) {
      handleError(error, 'Erro ao verificar favorito')
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
