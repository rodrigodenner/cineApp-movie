import { ref, onMounted } from 'vue'
import { getGenres } from '@/services/movies/getAllGenres'
import { handleError } from '@/utils/handleError'
import type {Genre} from "@/types/Genre.ts";


export const useGenres = () => {
  const genres = ref<Genre[]>([])
  const loading = ref(true)

  const fetchGenres = async () => {
    try {
      const response = await getGenres()
      genres.value = [{ id: 0, name: 'Todos' }, ...response.data.data]
    } catch (error) {
      handleError(error, 'Erro ao carregar os gêneros')
    } finally {
      loading.value = false
    }
  }

  onMounted(fetchGenres)

  return {
    genres,
    loading,
  }
}
