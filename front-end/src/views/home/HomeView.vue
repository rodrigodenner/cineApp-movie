<template>
  <div class="max-w-7xl mx-auto px-4 pt-20">
    <HeroBanner />
    <GenreFilter @select="handleGenreSelect" />

    <MovieSection
        v-if="!isTrendingLoading && !isGenreSelected"
        title="🎬 Em Cartaz"
        :movies="nowPlaying"
    />

    <SpinnerLoading v-if="isTrendingLoading && !isGenreSelected" />

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
        :title="`🎞️ Gênero selecionado`"
        :movies="genreMovies"
        :fetchMore="fetchMoreGenreMovies"
        :loadingMore="isGenreLoading"
    />
  </div>
</template>

<script setup lang="ts">
import HeroBanner from '@/components/hero-banner/HeroBanner.vue'
import GenreFilter from '@/components/genre-filter/GenreFilter.vue'
import MovieSection from '@/components/movie-section/MovieSection.vue'
import SpinnerLoading from '@/components/spinner-loading/SpinnerLoading.vue'
import MovieGrid from '@/components/movie-grid/MovieGrid.vue'

import { useNowPlaying } from '@/composables/useNowPlaying'
import { useTrendingMovies } from '@/composables/useTrendingMovies'
import { usePopularMovies } from '@/composables/usePopularMovies'
import {useGenreMovies} from "@/composables/useGenreMovie.ts";
import {computed} from "vue";


const { movies: nowPlaying } = useNowPlaying()
const { trendingMovies, isTrendingLoading, fetchTrending } = useTrendingMovies()
const { movies: popularMovies, isLoading: isPopularLoading, fetchPopular } = usePopularMovies()

const {
  selectedGenre,
  movies: genreMovies,
  loading: isGenreLoading,
  fetchMoviesByGenre,
  fetchMoreMoviesByGenre: fetchMoreGenreMovies
} = useGenreMovies()

const isGenreSelected = computed(() => selectedGenre.value !== 0)

const handleGenreSelect = async (genreId: number) => {
  await fetchMoviesByGenre(genreId)
}
</script>
