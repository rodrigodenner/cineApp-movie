import { ref, onMounted } from 'vue'
import { getTrending } from '@/services/movies/getTrending'
import { handleError } from '@/utils/handleError'
import type {Movie} from "@/types/Movie.ts";


export function useTrendingMovies(options?: { onError?: () => void }) {
  const trendingMovies = ref<Movie[]>([])
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
      handleError(error, 'Erro ao buscar filmes em alta')
      options?.onError?.()
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
