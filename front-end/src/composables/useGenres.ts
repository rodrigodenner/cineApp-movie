import {ref, onMounted} from 'vue'
import {getGenres} from '@/services/genreService'

export const useGenres = () => {
  const genres = ref<{ id: number; name: string }[]>([])
  const loading = ref(true)

  const fetchGenres = async () => {
    try {
      const response = await getGenres()
      genres.value = [{id: 0, name: 'Todos'}, ...response.data.data]
    } catch (error) {
      console.error('Erro ao carregar os gêneros:', error)
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
