<template>
  <div class="min-h-screen bg-zinc-900 text-white">
    <div
        class="relative w-full h-[500px] bg-cover bg-center"
        :style="`background-image: url(${movie?.poster_path})`"
    >
      <div class="absolute inset-0 bg-gradient-to-t from-zinc-900 via-zinc-900/80 to-transparent"></div>
      <button
          @click="router.back()"
          class="absolute top-24 left-4 text-lg font-bold text-red-500 bg-zinc-800/70 px-3 py-1 rounded-full hover:bg-zinc-700 transition cursor-pointer"
      >
        ← Voltar
      </button>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-10 flex flex-col md:flex-row gap-10">
      <img
          :src="movie?.poster_path"
          :alt="movie?.title"
          class="w-52 h-72 rounded-xl object-cover shadow-lg"
      />

      <div class="flex-1">
        <h1 class="text-4xl font-bold mb-3">{{ movie?.title }}</h1>

        <div class="flex items-center gap-4 text-zinc-400 text-sm mb-4">
          <span>⭐ <strong class="text-white">{{ movie?.vote_average?.toFixed(1) }}</strong> /10</span>
          <span>📅 {{ releaseYear }}</span>
          <span>⏱️ 120 min</span>
        </div>

        <div class="flex gap-2 flex-wrap mb-6">
          <span
              v-for="genre in movie?.genres"
              :key="genre.id"
              class="bg-red-800 text-white px-3 py-1 rounded-full text-sm"
          >
            {{ genre.name }}
          </span>
        </div>

        <h2 class="text-xl font-semibold mb-2">Sinopse</h2>
        <p class="text-zinc-300 mb-6">
          {{ movie?.overview }}
        </p>

        <button
            @click="handleFavoriteClick"
            :disabled="isLoading"
            class="border border-white text-white rounded px-5 py-2 flex items-center gap-2 hover:bg-red-800 cursor-pointer hover:text-white transition"
        >
          <span v-if="isFavorite"><span class="mr-2">❤️</span> Remover dos Favoritos</span>
          <span v-else><span class="mr-2">🤍</span> Adicionar aos Favoritos</span>
        </button>

      </div>
    </div>

    <MovieProductionDetails :movie="movie" />

    <div class="max-w-7xl mx-auto px-4 pb-20" v-if="relatedMovies.length">
      <MovieTrailer v-if="movie?.trailer_url" :trailer-url="movie.trailer_url" />
    </div>
    <div class="max-w-7xl mx-auto px-4 pb-20" v-if="relatedMovies.length">
      <MovieSection title="🎥 Filmes Relacionados" :movies="relatedMovies"/>
    </div>
  </div>
</template>
<script setup lang="ts">
import {ref, onMounted, computed, watch} from 'vue'
import {useRoute, useRouter} from 'vue-router'
import {getMovieDetails} from '@/services/movieService'
import {useMovieFavorite} from '@/composables/useMovieFavorite'
import {useRelatedMovies} from '@/composables/useRelatedMovies'
import MovieSection from '@/components/movie-section/MovieSection.vue'
import {useAuthStore} from "@/stores/auth.ts";
import {useModalStore} from "@/stores/useModalStore.ts";
import MovieTrailer from "@/components/movie-detail/MovieTrailer.vue";
import MovieProductionDetails from "@/components/movie-detail/MovieProductionDetails.vue";


const route = useRoute()
const router = useRouter()
const authStore = useAuthStore()
const modalStore = useModalStore()
const movie = ref<any>(null)

const {isFavorite, isLoading, toggleFavorite, checkIfFavorite} = useMovieFavorite()
const {relatedMovies, fetchRelatedMovies} = useRelatedMovies()

const releaseYear = computed(() =>
    movie.value?.release_date
        ? new Date(movie.value.release_date).getFullYear()
        : ''
)

const handleFavoriteClick = () => {
  if (!authStore.isAuthenticated) {
    modalStore.showLogin()
    return
  }

  toggleFavorite(movie.value.id)
}

onMounted(async () => {
  const response = await getMovieDetails(Number(route.params.id))
  movie.value = response.data.data

  const genreIds = movie.value.genres.map((g: any) => g.id)
  await fetchRelatedMovies(movie.value.id, genreIds, 16)

  if (authStore.isAuthenticated) {
    await checkIfFavorite(movie.value.id)
  }
})

watch(() => route.params.id, async (newId) => {
  const response = await getMovieDetails(Number(newId))
  movie.value = response.data.data

  const genreIds = movie.value.genres.map((g: any) => g.id)
  await fetchRelatedMovies(movie.value.id, genreIds, 16)

  if (authStore.isAuthenticated) {
    await checkIfFavorite(movie.value.id)
  }
})

</script>
