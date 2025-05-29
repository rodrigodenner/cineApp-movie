<template>
  <div class="max-w-7xl mx-auto px-4 pt-20">
    <HeroBanner />
    <GenreFilter />

    <MovieSection
        v-if="!isTrendingLoading"
        title="🎬 Em Cartaz"
        :movies="nowPlaying"
    />

    <SpinnerLoading v-if="isTrendingLoading" />

    <MovieGrid
        v-if="trendingMovies.length"
        title="🔥 Em Alta"
        :movies="trendingMovies"
        :fetchMore="fetchTrending"
        :loadingMore="isTrendingLoading"
    />


    <MovieGrid
        v-if="popularMovies.length"
        title="⭐ Populares"
        :movies="popularMovies"
        :fetchMore="fetchPopular"
        :loadingMore="isPopularLoading"
    />


  </div>
</template>

<script setup lang="ts">
import HeroBanner from '@/components/hero-banner/HeroBanner.vue'
import GenreFilter from '@/components/genre-filter/GenreFilter.vue'
import MovieSection from '@/components/movie-section/MovieSection.vue'
import SpinnerLoading from '@/components/spinner-loading/SpinnerLoading.vue'
import { useNowPlaying } from '@/composables/useNowPlaying'
import { useTrendingMovies } from '@/composables/useTrendingMovies'
import MovieGrid from "@/components/movie-grid/MovieGrid.vue";
import { usePopularMovies } from '@/composables/usePopularMovies'

const { movies: nowPlaying } = useNowPlaying()
const { trendingMovies, isTrendingLoading, fetchTrending } = useTrendingMovies()
const {movies: popularMovies, isLoading: isPopularLoading, fetchPopular} = usePopularMovies()

</script>
