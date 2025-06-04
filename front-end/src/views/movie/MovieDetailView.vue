<template>
  <div v-if="movie" class="min-h-screen bg-zinc-900 text-white">
    <MovieBanner :poster="movie?.poster_path" :onBack="router.back" />

    <MovieHeaderInfo
        :poster="movie?.poster_path"
        :title="movie.title"
        :vote="movie.vote_average"
        :releaseYear="releaseYear"
        :genres="movie.genres"
        :overview="movie.overview"
        :isFavorite="isFavorite"
        :isLoading="isLoading"
        :onToggleFavorite="handleFavoriteClick"
    />

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
import {useMovieFavorite} from '@/composables/movies/useMovieFavorite.ts'
import {useRelatedMovies} from '@/composables/movies/useRelatedMovies.ts'
import MovieSection from '@/components/movie-section/MovieSection.vue'
import {useAuthStore} from "@/stores/auth.ts";
import {useModalStore} from "@/stores/useModalStore.ts";
import MovieTrailer from "@/components/movie-detail/MovieTrailer.vue";
import MovieProductionDetails from "@/components/movie-detail/MovieProductionDetails.vue";
import MovieBanner from "@/components/movie-detail/MovieBanner.vue";
import MovieHeaderInfo from "@/components/movie-detail/MovieHeaderInfo.vue";
import {getMovieDetails} from "@/services/movies/getDetails.ts";


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
  console.log('ENTROU NA TELA DE DETALHES')
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
