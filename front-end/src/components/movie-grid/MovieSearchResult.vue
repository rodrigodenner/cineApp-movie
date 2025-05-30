<template>
  <div>
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
  </div>
</template>

<script setup lang="ts">
import MovieGrid from '@/components/movie-grid/MovieGrid.vue'

const props = defineProps<{
  hasGlobalError: boolean
  searchQuery: string | null
  isSearchLoading: boolean
  searchMovies: any[]
}>()
</script>
