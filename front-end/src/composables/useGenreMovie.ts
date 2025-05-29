import { ref } from 'vue'
import { getMoviesByGenre } from '@/services/movieService'

export function useGenreMovies(options?: { onError?: () => void }) {
  const selectedGenres = ref<number[]>([])
  const movies = ref<any[]>([])
  const loading = ref(false)

  const fetchMoviesByGenres = async (genreIds: number[]) => {
    if (genreIds.includes(0)) {
      selectedGenres.value = []
      movies.value = []
      loading.value = false
      return
    }

    selectedGenres.value = genreIds
    loading.value = true
    movies.value = []

    try {
      const promises = genreIds.map((id) => getMoviesByGenre(id))
      const results = await Promise.all(promises)

      const combined = results.flatMap(res => res.data.data)

      movies.value = combined.filter(
          (movie, index, self) =>
              self.findIndex((m) => m.id === movie.id) === index
      )
    } catch (error) {
      console.error('Erro ao buscar filmes por múltiplos gêneros:', error)
      options?.onError?.()
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
