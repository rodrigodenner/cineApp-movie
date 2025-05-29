import {ref} from 'vue'
import {getMoviesByGenre} from '@/services/movieService'

export function useRelatedMovies() {
  const relatedMovies = ref<any[]>([])
  const isLoading = ref(false)

  const fetchRelatedMovies = async (movieId: number, genreIds: number[], limit = 16) => {
    isLoading.value = true
    const relatedSet = new Map<number, any>()

    for (const genreId of genreIds) {
      if (relatedSet.size >= limit) break

      try {
        const res = await getMoviesByGenre(genreId)
        const filtered = res.data.data.filter((m: any) => m.id !== movieId)

        for (const item of filtered) {
          if (!relatedSet.has(item.id)) {
            relatedSet.set(item.id, item)
            if (relatedSet.size >= limit) break
          }
        }
      } catch (err) {
        console.warn(`Erro ao buscar filmes para o gênero ${genreId}:`, err)
      }
    }

    relatedMovies.value = Array.from(relatedSet.values())
    isLoading.value = false
  }

  return {
    relatedMovies,
    isLoading,
    fetchRelatedMovies,
  }
}
