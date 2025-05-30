<template>
  <div
      class="relative w-full h-[500px] bg-cover bg-center"
      :style="`background-image: url(${poster})`"
  >
    <div class="absolute inset-0 bg-gradient-to-t from-zinc-900 via-zinc-900/80 to-transparent"></div>
    <button
        @click="onBack"
        class="absolute top-24 left-4 text-lg font-bold text-red-500 bg-zinc-800/70 px-3 py-1 rounded-full hover:bg-zinc-700 transition cursor-pointer"
    >
      ← Voltar
    </button>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  poster: string
  onBack: () => void
}>()
</script>
