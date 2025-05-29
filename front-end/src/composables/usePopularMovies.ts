import {ref, onMounted} from 'vue'
import {getPopularMovies} from '@/services/movieService'

export function usePopularMovies(options?: { onError?: () => void }) {
  const movies = ref<any[]>([])
  const isLoading = ref(false)
  const currentPage = ref(1)

  const fetchPopular = async () => {
    isLoading.value = true
    try {
      const response = await getPopularMovies(currentPage.value)
      movies.value.push(...response.data.data)
      currentPage.value++
    } catch (error) {
      console.error('Erro ao buscar filmes populares:', error)
      options?.onError?.()
    } finally {
      isLoading.value = false
    }
  }

  onMounted(fetchPopular)

  return {
    movies,
    isLoading,
    fetchPopular
  }
}
