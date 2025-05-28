import { ref, onMounted } from 'vue'
import { getPopularMovies } from '@/services/movieService'

export function usePopularMovies() {
  const movies = ref([])
  const isLoading = ref(false)

  const fetchPopular = async () => {
    isLoading.value = true
    try {
      const response = await getPopularMovies()
      movies.value = response.data.data
    } catch (error) {
      console.error('Erro ao buscar populares:', error)
    } finally {
      isLoading.value = false
    }
  }

  onMounted(fetchPopular)

  return { movies, isLoading }
}
