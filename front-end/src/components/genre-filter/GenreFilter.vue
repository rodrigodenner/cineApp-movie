<template>
  <section class="mb-12">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">Filtrar por Gênero</h2>

      <button
          v-if="selectedGenres.length"
          @click="clearFilters"
          class="text-sm text-red-400 hover:text-red-500 underline cursor-pointer"
      >
        Limpar filtros
      </button>
    </div>

    <div v-if="loading" class="text-zinc-400 text-sm">Carregando...</div>

    <div v-else class="flex flex-wrap gap-3">
      <button
          v-for="genre in genres"
          :key="genre.id"
          @click="handleSelect(genre.id)"
          :class="[
          'px-4 py-1 rounded-full transition-colors duration-200',
          selectedGenres.includes(genre.id)
            ? 'bg-red-500 text-white'
            : 'bg-zinc-800 text-zinc-300 hover:bg-zinc-700'
        ]"
      >
        {{ genre.name }}
      </button>
    </div>
  </section>
</template>
<script setup lang="ts">
import {ref, onMounted} from 'vue'
import {useGenres} from '@/composables/useGenres'

const emit = defineEmits(['select'])
const selectedGenres = ref<number[]>([0])
const {genres, loading} = useGenres()

const handleSelect = (id: number) => {
  const maxSelection = 3

  if (id === 0) {
    selectedGenres.value = [0]
    emit('select', [...selectedGenres.value])
    return
  }

  selectedGenres.value = selectedGenres.value.filter((g) => g !== 0)

  const alreadySelected = selectedGenres.value.includes(id)
  if (alreadySelected) {
    selectedGenres.value = selectedGenres.value.filter((g) => g !== id)
    emit('select', [...selectedGenres.value])
    return
  }

  if (selectedGenres.value.length >= maxSelection) return

  selectedGenres.value.push(id)
  emit('select', [...selectedGenres.value])
}


const clearFilters = () => {
  selectedGenres.value = [0]
  emit('select', [])
}

onMounted(() => {
  if (!selectedGenres.value.length) {
    selectedGenres.value = [0]
    emit('select', [0])
  }
})
</script>
