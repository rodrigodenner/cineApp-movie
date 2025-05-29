import { ref, onMounted } from 'vue'
import { getTrending } from '@/services/movieService'

export function useTrendingMovies() {
  const trendingMovies = ref<any[]>([])
  const isLoading = ref(false)
  const currentPage = ref(1)

  const fetchTrending = async () => {
    if (isLoading.value) return

    isLoading.value = true
    try {
      const response = await getTrending(currentPage.value)
      trendingMovies.value.push(...response.data.data)
      currentPage.value++
    } catch (error) {
      console.error('Erro ao buscar filmes em alta:', error)
    } finally {
      isLoading.value = false
    }
  }

  onMounted(fetchTrending)

  return {
    trendingMovies,
    isTrendingLoading: isLoading,
    fetchTrending,
  }
}
