<script setup lang="ts">
import { ref, onMounted } from 'vue'
import EmblaCarousel from 'embla-carousel'
import MovieCard from '@/components/movie-card/MovieCard.vue'

defineProps<{
  title: string
  movies: any[]
}>()

const viewport = ref<HTMLElement | null>(null)
const embla = ref<ReturnType<typeof EmblaCarousel> | null>(null)

const scrollPrev = () => embla.value?.scrollPrev()
const scrollNext = () => embla.value?.scrollNext()

onMounted(() => {
  if (viewport.value) {
    embla.value = EmblaCarousel(viewport.value, {
      align: 'start',
      loop: true,
      slidesToScroll: 1,
    })
  }
})

</script>

<template>
  <section class="mb-10">
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-xl font-bold">{{ title }}</h2>
      <div class="flex gap-2">
        <button @click="scrollPrev"
                class="w-8 h-8 flex items-center justify-center rounded-full bg-zinc-800 text-white cursor-pointer">
          ‹
        </button>
        <button @click="scrollNext"
                class="w-8 h-8 flex items-center justify-center rounded-full bg-zinc-800 text-white cursor-pointer">
          ›
        </button>
      </div>
    </div>

    <div class="relative">
      <div class="overflow-hidden" ref="viewport">
        <div class="flex gap-4">
          <!-- 8 por tela -->
          <div
              v-for="movie in movies"
              :key="movie.id"
              class="px-2
              flex-[0_0_50%]
              sm:flex-[0_0_33.3333%]
              md:flex-[0_0_25%]
              lg:flex-[0_0_16.6667%]
              xl:flex-[0_0_12.5%]"
          >
            <MovieCard :movie="movie" />
          </div>

        </div>
      </div>
    </div>
  </section>
</template>
