import {ref, onMounted} from 'vue'
import {getNowPlaying} from '@/services/movieService'

export const useNowPlaying = (options?: { onError?: () => void }) => {
  const movies = ref([])
  const loading = ref(true)
  const error = ref('')

  const fetchNowPlaying = async () => {
    try {
      const response = await getNowPlaying()
      movies.value = response.data.data
    } catch (err: any) {
      error.value = err?.response?.data?.message || 'Erro ao carregar filmes em cartaz.'
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
