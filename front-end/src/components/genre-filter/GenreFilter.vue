<script setup lang="ts">
import { ref } from 'vue'
import { useGenres } from '@/composables/useGenres'

const emit = defineEmits(['select'])

const selected = ref(0)
const { genres, loading } = useGenres()

const handleSelect = (id: number) => {
  selected.value = id
  emit('select', id)
}
</script>

<template>
  <section class="mb-12">
    <h2 class="text-2xl font-bold mb-4">Filtrar por Gênero</h2>

    <div v-if="loading" class="text-zinc-400 text-sm">Carregando...</div>

    <div v-else class="flex flex-wrap gap-3">
      <button
          v-for="genre in genres"
          :key="genre.id"
          @click="handleSelect(genre.id)"
          :class="[
          'px-4 py-1 rounded-full transition-colors duration-200',
          selected === genre.id
            ? 'bg-red-500 text-white'
            : 'bg-zinc-800 text-zinc-300 hover:bg-zinc-700'
        ]"
      >
        {{ genre.name }}
      </button>
    </div>
  </section>
</template>
