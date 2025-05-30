<template>
  <div class="max-w-7xl mx-auto px-4 mb-10">
    <h2 class="text-xl font-bold mb-4">🎬 Trailer</h2>
    <div class="aspect-video w-full rounded-lg overflow-hidden shadow-lg">
      <iframe
          :src="embedUrl"
          frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen
          class="w-full h-full"
      ></iframe>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'

const props = defineProps<{
  trailerUrl: string
}>()

const embedUrl = computed(() => {
  const videoId = props.trailerUrl.split('v=')[1]?.split('&')[0]
  return videoId ? `https://www.youtube.com/embed/${videoId}` : ''
})
</script>
