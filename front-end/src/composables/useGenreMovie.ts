import { ref } from 'vue'
import { getMoviesByGenre } from '@/services/movieService'

export const useGenreMovies = () => {
  const selectedGenre = ref(0)
  const movies = ref([])
  const loading = ref(false)

  const fetchMoviesByGenre = async (genreId: number) => {
    selectedGenre.value = genreId
    loading.value = true

    try {
      if (genreId === 0) {
        movies.value = []
        return
      }

      const response = await getMoviesByGenre(genreId)
      movies.value = response.data
    } catch (error) {
      console.error('Erro ao buscar filmes por gênero:', error)
    } finally {
      loading.value = false
    }
  }

  return {
    selectedGenre,
    movies,
    loading,
    fetchMoviesByGenre,
  }
}
