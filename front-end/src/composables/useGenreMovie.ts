import { ref } from 'vue'
import { getMoviesByGenre } from '@/services/movieService'

export const useGenreMovies = () => {
  const selectedGenre = ref(0)
  const movies = ref<any[]>([])
  const loading = ref(false)
  const page = ref(1)

  const fetchMoviesByGenre = async (genreId: number) => {
    selectedGenre.value = genreId
    page.value = 1
    movies.value = []
    loading.value = true

    try {
      const response = await getMoviesByGenre(genreId, page.value)
      movies.value = response.data.data
    } catch (error) {
      console.error('Erro ao buscar filmes por gênero:', error)
    } finally {
      loading.value = false
    }
  }

  const fetchMoreMoviesByGenre = async () => {
    if (!selectedGenre.value) return

    page.value++
    loading.value = true

    try {
      const response = await getMoviesByGenre(selectedGenre.value, page.value)
      movies.value.push(...response.data.data)
    } catch (error) {
      console.error('Erro ao buscar mais filmes por gênero:', error)
    } finally {
      loading.value = false
    }
  }

  return {
    selectedGenre,
    movies,
    loading,
    fetchMoviesByGenre,
    fetchMoreMoviesByGenre,
  }
}
