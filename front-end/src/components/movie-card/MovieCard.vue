<template>
  <div
      @click="goToDetails"
      class="cursor-pointer transition-transform hover:scale-105"
  >
    <img
        :src="movie.poster_path || ''"
        :alt="movie.title"
        class="rounded-xl w-36 h-52 object-cover"
    />
  </div>
</template>

<script setup lang="ts">
import { useRouter } from 'vue-router'
import type { Movie } from '@/types/Movie'

const props = defineProps<{
  movie: Movie
}>()

const router = useRouter()

const goToDetails = () => {
  const movieId = props.movie.id || props.movie.tmdb_id
  if (!movieId) return
  console.log({ name: 'movie-detail', params: { id: movieId } })
  router.push({ name: 'movie-detail', params: { id: movieId } })
}
</script>
