import { ref } from 'vue'
import { getMoviesByGenre } from '@/services/movieService'

export function useGenreMovies() {
  const selectedGenres = ref<number[]>([])
  const movies = ref<any[]>([])
  const loading = ref(false)

  const fetchMoviesByGenres = async (genreIds: number[]) => {
    selectedGenres.value = genreIds
    loading.value = true
    movies.value = []

    try {
      const promises = genreIds.map((id) => getMoviesByGenre(id))
      const results = await Promise.all(promises)

      const combined = results.flatMap(res => res.data.data)

      // Remover filmes duplicados
      const uniqueMovies = combined.filter(
          (movie, index, self) =>
              self.findIndex((m) => m.id === movie.id) === index
      )

      movies.value = uniqueMovies
    } catch (error) {
      console.error('Erro ao buscar filmes por múltiplos gêneros:', error)
    } finally {
      loading.value = false
    }
  }

  return {
    selectedGenres,
    movies,
    loading,
    fetchMoviesByGenres,
  }
}
