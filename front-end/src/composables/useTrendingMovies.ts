import { ref, onMounted } from 'vue'
import { getTrending } from '@/services/movieService'

export function useTrendingMovies() {
  const trendingMovies = ref([])
  const isTrendingLoading = ref(false)

  const fetchTrending = async () => {
    isTrendingLoading.value = true
    try {
      const response = await getTrending()
      trendingMovies.value = response.data.data
    } catch (error) {
      console.error('Erro ao buscar filmes em alta:', error)
    } finally {
      isTrendingLoading.value = false
    }
  }

  onMounted(fetchTrending)

  return {
    trendingMovies,
    isTrendingLoading,
  }
}
