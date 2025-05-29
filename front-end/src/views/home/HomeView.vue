<template>
  <div class="max-w-7xl mx-auto px-4 pt-20">
    <div
        v-if="hasGlobalError"
        class="text-center text-red-500 bg-red-900/20 border border-red-600 rounded p-6"
    >
      O sistema está temporariamente fora do ar. Tente novamente mais tarde.
    </div>

    <template v-else-if="searchQuery">
      <h2 class="text-2xl font-bold mb-6">🔍 Resultados para: "{{ searchQuery }}"</h2>

      <div v-if="isSearchLoading" class="text-white">Carregando...</div>

      <div v-else-if="searchMovies.length">
        <MovieGrid :movies="searchMovies" title="Filmes encontrados"/>
      </div>

      <div v-else class="text-zinc-400 text-sm">
        Nenhum filme encontrado para sua busca. Tente outro nome.
      </div>
    </template>

    <template v-else>
      <HeroBanner/>
      <GenreFilter @select="handleGenreSelect"/>

      <MovieSection
          v-if="!isTrendingLoading && !isGenreSelected"
          title="🎬 Em Cartaz"
          :movies="nowPlaying"
      />

      <SpinnerLoading v-if="isTrendingLoading && !isGenreSelected"/>

      <MovieGrid
          v-if="!isGenreSelected && trendingMovies.length"
          title="🔥 Em Alta"
          :movies="trendingMovies"
          :fetchMore="fetchTrending"
          :loadingMore="isTrendingLoading"
      />

      <MovieGrid
          v-if="!isGenreSelected && popularMovies.length"
          title="⭐ Populares"
          :movies="popularMovies"
          :fetchMore="fetchPopular"
          :loadingMore="isPopularLoading"
      />

      <MovieGrid
          v-if="isGenreSelected && genreMovies.length"
          :title="`🎞 Filmes filtrados por gênero`"
          :movies="genreMovies"
      />
    </template>
  </div>
</template>
<script setup lang="ts">
import {ref, computed, onMounted, watch} from 'vue'
import {useRoute} from 'vue-router'
import HeroBanner from '@/components/hero-banner/HeroBanner.vue'
import GenreFilter from '@/components/genre-filter/GenreFilter.vue'
import MovieSection from '@/components/movie-section/MovieSection.vue'
import SpinnerLoading from '@/components/spinner-loading/SpinnerLoading.vue'
import MovieGrid from '@/components/movie-grid/MovieGrid.vue'
import {useNowPlaying} from '@/composables/useNowPlaying'
import {useTrendingMovies} from '@/composables/useTrendingMovies'
import {usePopularMovies} from '@/composables/usePopularMovies'
import {useGenreMovies} from '@/composables/useGenreMovie'
import {useSearchMovies} from '@/composables/useSearchMovies'

const route = useRoute()
const hasGlobalError = ref(false)

const handleGlobalError = () => {
  hasGlobalError.value = true
}

const {movies: nowPlaying} = useNowPlaying({onError: handleGlobalError})
const {trendingMovies, isTrendingLoading, fetchTrending} = useTrendingMovies({onError: handleGlobalError})
const {
  movies: popularMovies,
  isLoading: isPopularLoading,
  fetchPopular
} = usePopularMovies({onError: handleGlobalError})

const {
  selectedGenres,
  movies: genreMovies,
  loading: isGenreLoading,
  fetchMoviesByGenres
} = useGenreMovies({onError: handleGlobalError})

const {
  movies: searchMovies,
  loading: isSearchLoading,
  fetchSearchResults
} = useSearchMovies({onError: handleGlobalError})

const isGenreSelected = computed(() => selectedGenres.value.length > 0)
const searchQuery = computed(() => route.query.q as string)

const handleGenreSelect = async (genreIds: number[]) => {
  if (genreIds.length === 0) return
  await fetchMoviesByGenres(genreIds)
}

onMounted(() => {
  if (searchQuery.value) {
    fetchSearchResults(searchQuery.value, true)
  }
})

watch(() => searchQuery.value, (newQuery) => {
  if (newQuery) fetchSearchResults(newQuery, true)
})
</script>
