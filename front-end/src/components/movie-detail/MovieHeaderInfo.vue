<template>
  <div class="max-w-7xl mx-auto px-4 py-10 flex flex-col md:flex-row gap-10">
    <img
        :src="poster"
        :alt="title"
        class="w-52 h-72 rounded-xl object-cover shadow-lg"
    />

    <div class="flex-1">
      <h1 class="text-4xl font-bold mb-3">{{ title }}</h1>

      <div class="flex items-center gap-4 text-zinc-400 text-sm mb-4">
        <span>⭐ <strong class="text-white">{{ vote.toFixed(1) }}</strong> /10</span>
        <span>📅 {{ releaseYear }}</span>
        <span>⏱️ 120 min</span>
      </div>

      <div class="flex gap-2 flex-wrap mb-6">
        <span
            v-for="genre in genres"
            :key="genre.id"
            class="bg-red-800 text-white px-3 py-1 rounded-full text-sm"
        >
          {{ genre.name }}
        </span>
      </div>

      <h2 class="text-xl font-semibold mb-2">Sinopse</h2>
      <p class="text-zinc-300 mb-6">{{ overview }}</p>

      <button
          @click="onToggleFavorite"
          :disabled="isLoading"
          class="border border-white text-white rounded px-5 py-2 flex items-center gap-2 hover:bg-red-800 cursor-pointer hover:text-white transition"
      >
        <span v-if="isFavorite"><span class="mr-2">❤️</span> Remover dos Favoritos</span>
        <span v-else><span class="mr-2">🤍</span> Adicionar aos Favoritos</span>
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  poster: string
  title: string
  vote: number
  releaseYear: number | string
  genres: { id: number; name: string }[]
  overview: string
  isFavorite: boolean
  isLoading: boolean
  onToggleFavorite: () => void
}>()
</script>
