<template>
  <div class="max-w-7xl mx-auto px-4 pt-20">
    <HeroBanner />
    <GenreFilter />
    <MovieSection title="🎬 Em Cartaz" :movies="nowPlaying" />
    <MovieSection title="🔥 Em Alta" :movies="trending" />
    <MovieSection title="⭐ Populares" :movies="popular" />
  </div>
</template>

<script setup lang="ts">

import HeroBanner from "@/components/hero-banner/HeroBanner.vue";
import GenreFilter from "@/components/genre-filter/GenreFilter.vue";
import MovieSection from "@/components/movie-section/MovieSection.vue";

const nowPlaying = [/* array de filmes */]
const trending = [/* array de filmes */]
const popular = [/* array de filmes */]
</script>

<style scoped>

</style>
