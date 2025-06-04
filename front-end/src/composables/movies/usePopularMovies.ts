import { ref, onMounted } from 'vue'
import { getPopularMovies } from '@/services/movies/getPopular'
import { handleError } from '@/utils/handleError'
import type {Movie} from "@/types/Movie.ts";


export function usePopularMovies(options?: { onError?: () => void }) {
  const movies = ref<Movie[]>([])
  const isLoading = ref(false)
  const currentPage = ref(1)

  const fetchPopular = async () => {
    isLoading.value = true
    try {
      const response = await getPopularMovies(currentPage.value)
      movies.value.push(...(response.data.data as Movie[]))
      currentPage.value++
    } catch (error) {
      handleError(error, 'Erro ao buscar filmes populares')
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
