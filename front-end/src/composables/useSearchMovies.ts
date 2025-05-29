import { ref } from 'vue'
import { getMoviesBySearch } from '@/services/movieService'

export const useSearchMovies = (options?: { onError?: () => void }) => {
  const movies = ref<any[]>([])
  const loading = ref(false)
  const page = ref(1)
  const hasMore = ref(true)

  const fetchSearchResults = async (query: string, reset = false) => {
    if (loading.value || !query) return

    if (reset) {
      movies.value = []
      page.value = 1
      hasMore.value = true
    }

    loading.value = true

    try {
      const response = await getMoviesBySearch(query, page.value)
      const data = response.data.data

      if (data.length === 0) hasMore.value = false

      movies.value.push(...data)
      page.value++
    } catch (e) {
      console.error('Erro ao buscar filmes:', e)
      options?.onError?.()
    } finally {
      loading.value = false
    }
  }

  return {
    movies,
    loading,
    fetchSearchResults,
    hasMore
  }
}
