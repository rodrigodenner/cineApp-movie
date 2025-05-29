<template>
  <div class="mt-12">
    <h2 class="text-xl font-semibold mb-4">{{ title }}</h2>

    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-4">
      <MovieCard
          v-for="movie in visibleMovies"
          :key="movie.id"
          :movie="movie"
      />
    </div>

    <div class="flex justify-center mt-6" v-if="canShowMore">
      <button
          @click="loadMore"
          :disabled="loadingMore"
          class="flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 cursor-pointer rounded"
      >
        <svg
            v-if="loadingMore"
            class="animate-spin h-5 w-5 text-white"
            viewBox="0 0 24 24"
        >
          <circle
              class="opacity-25"
              cx="12"
              cy="12"
              r="10"
              stroke="currentColor"
              stroke-width="4"
              fill="none"
          />
          <path
              class="opacity-75"
              fill="currentColor"
              d="M4 12a8 8 0 018-8v8z"
          />
        </svg>
        <span v-if="!loadingMore">Ver mais</span>
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, watch } from 'vue'
import MovieCard from '@/components/movie-card/MovieCard.vue'

const props = defineProps<{
  title: string
  movies: any[]
  fetchMore?: () => Promise<void>
  loadingMore?: boolean
}>()

const rowsToShow = ref(2)

const visibleMovies = computed(() =>
    props.movies.slice(0, rowsToShow.value * 8)
)

const canShowMore = computed(() =>
    props.movies.length >= rowsToShow.value * 8
)

const loadMore = async () => {
  rowsToShow.value += 2
  if (props.fetchMore) {
    await props.fetchMore()
  }
}
</script>

