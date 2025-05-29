<template>
  <div class="max-w-7xl mx-auto px-4 py-12 text-white">
    <div class="bg-zinc-800 rounded-xl mt-10 p-6 flex flex-col items-center mb-10 border border-zinc-700">
      <div class="w-20 h-20 bg-red-500 rounded-full flex items-center justify-center text-3xl">🎬</div>
      <h2 class="mt-4 text-2xl font-bold">{{ authStore.user?.name }}</h2>
      <p class="text-zinc-400">{{ authStore.user?.email }}</p>
      <button
          class="mt-4 text-sm px-4 py-2 rounded bg-zinc-700 hover:bg-zinc-600 cursor-pointer transition"
          @click="showEditModal = true"
      >
        ⚙️ Editar Perfil
      </button>
    </div>

    <h2 class="text-2xl font-bold mb-2">
      ❤️ Meus Favoritos
      <span class="text-sm text-zinc-400">({{ movies.length }})</span>
    </h2>

    <div class="bg-zinc-800 rounded-lg p-6 mb-10 border border-zinc-700">
      <label class="block text-sm text-zinc-400 mb-2">Buscar por título</label>
      <div class="relative w-full">
        <input
            v-model="search"
            type="text"
            placeholder="Buscar nos favoritos..."
            class="w-full bg-zinc-900 text-white px-4 py-2 pr-10 rounded focus:outline-none focus:ring-2 focus:ring-red-500"
        />
        <button
            v-if="search"
            @click="clearSearch"
            class="absolute inset-y-0 right-2 flex items-center justify-center cursor-pointer"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500 hover:scale-110 transition-transform"
               fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
    </div>

    <GenreFilter @select="handleGenreSelect"/>

    <MovieGrid
        v-if="movies.length"
        title="🎬 Filmes Favoritos"
        :movies="movies"
    />

    <div v-else class="text-zinc-400 text-sm">
      Nenhum favorito encontrado com os filtros aplicados.
    </div>

    <ProfileEditModal v-if="showEditModal" @close="showEditModal = false"/>
  </div>
</template>
<script setup lang="ts">
import {ref, onMounted, watch} from 'vue'
import {useAuthStore} from '@/stores/auth'
import {getFavoriteMovies} from '@/services/movieService'
import GenreFilter from '@/components/genre-filter/GenreFilter.vue'
import MovieGrid from '@/components/movie-grid/MovieGrid.vue'
import ProfileEditModal from "@/components/auth-modals/profile-edit/ProfileEditModal.vue";


const authStore = useAuthStore()
const search = ref('')
const selectedGenres = ref<number[]>([])
const movies = ref([])
const loading = ref(false)
const showEditModal = ref(false)

let debounceTimer: ReturnType<typeof setTimeout>

const fetchFavorites = async (searchTerm?: string | number) => {
  loading.value = true
  try {
    const response = await getFavoriteMovies(searchTerm?.toString())
    movies.value = response.data.data
  } catch (e) {
    console.error('Erro ao buscar favoritos:', e)
  } finally {
    loading.value = false
  }
}

const handleGenreSelect = (genres: number[]) => {
  selectedGenres.value = genres
  if (genres.length && !genres.includes(0)) {
    fetchFavorites(genres[0])
  } else {
    fetchFavorites()
  }
}

const clearSearch = () => {
  search.value = ''
  fetchFavorites()
}

watch(search, (newVal) => {
  clearTimeout(debounceTimer)
  debounceTimer = setTimeout(() => {
    fetchFavorites(newVal)
  }, 500)
})

onMounted(() => {
  fetchFavorites()
})
</script>
