import { ref, onMounted } from 'vue'
import { handleError } from '@/utils/handleError'
import type { Movie } from '@/types/Movie'
import { getNowPlaying } from '@/services/movies/getNowPlaying'

export const useNowPlaying = (options?: { onError?: () => void }) => {
  const movies = ref<Movie[]>([])
  const loading = ref(true)
  const error = ref('')

  const fetchNowPlaying = async () => {
    try {
      const response = await getNowPlaying()
      movies.value = response.data.data
    } catch (err: any) {
      error.value = handleError(err, 'Erro ao carregar filmes em cartaz.')
      options?.onError?.()
    } finally {
      loading.value = false
    }
  }

  onMounted(fetchNowPlaying)

  return {
    movies,
    loading,
    error,
    fetchNowPlaying,
  }
}
