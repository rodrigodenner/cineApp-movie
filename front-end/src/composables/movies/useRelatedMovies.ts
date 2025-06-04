import { ref } from 'vue'
import { getMoviesByGenre } from '@/services/movies/getByGenre'
import { handleError } from '@/utils/handleError'
import type {Movie} from "@/types/Movie.ts";


export function useRelatedMovies() {
  const relatedMovies = ref<Movie[]>([])
  const isLoading = ref(false)

  const fetchRelatedMovies = async (movieId: number, genreIds: number[], limit = 16) => {
    isLoading.value = true
    const relatedSet = new Map<number, Movie>()

    for (const genreId of genreIds) {
      if (relatedSet.size >= limit) break

      try {
        const res = await getMoviesByGenre(genreId)
        const filtered = (res.data.data as Movie[]).filter((m) => m.id !== movieId)

        for (const item of filtered) {
          if (!relatedSet.has(item.id)) {
            relatedSet.set(item.id, item)
            if (relatedSet.size >= limit) break
          }
        }
      } catch (err) {
        handleError(err, `Erro ao buscar filmes do gênero ${genreId}`)
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
