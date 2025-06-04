// src/composables/movies/useSearchMovies.ts

import { ref } from 'vue'
import { getMoviesBySearch } from '@/services/movies/search'
import { handleError } from '@/utils/handleError'
import type { Movie } from '@/types/Movie'

export const useSearchMovies = (options?: { onError?: () => void }) => {
  const movies = ref<Movie[]>([])
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

      const data = response.data.data.map((movie: any) => ({
        ...movie,
        id: movie.id ?? movie.tmdb_id, // garante que sempre haja um `id` para navegação
      })) as Movie[]

      if (data.length === 0) hasMore.value = false

      movies.value.push(...data)
      page.value++
    } catch (e) {
      handleError(e, 'Erro ao buscar filmes')
      options?.onError?.()
    } finally {
      loading.value = false
    }
  }

  return {
    movies,
    loading,
    fetchSearchResults,
    hasMore,
  }
}
