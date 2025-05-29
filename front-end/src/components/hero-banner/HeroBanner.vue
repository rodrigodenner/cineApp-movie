<template>
  <section class="relative h-80 md:h-96 mb-12 rounded-xl overflow-hidden bg-black">
    <div class="relative h-full" ref="viewport">
      <div class="flex h-full">
        <div
            v-for="(slide, index) in slides"
            :key="index"
            class="flex-[0_0_100%] relative"
        >
          <img
              :src="slide.image"
              class="w-full h-full object-cover"
              :alt="slide.title"
          />
          <div class="absolute inset-0 z-10 flex flex-col justify-center items-center text-center bg-black/40">
            <h1 class="text-5xl font-extrabold text-white mb-2">{{ slide.title }}</h1>
            <p class="text-lg text-zinc-300">{{ slide.subtitle }}</p>
          </div>
        </div>
      </div>
    </div>

    <button
        @click="scrollPrev"
        class="absolute left-4 top-1/2 z-20 -translate-y-1/2 bg-white/30 hover:bg-white/50 text-white rounded-full p-2 backdrop-blur-md"
    >
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
      </svg>
      <span class="sr-only">Anterior</span>
    </button>
    <button
        @click="scrollNext"
        class="absolute right-4 top-1/2 z-20 -translate-y-1/2 bg-white/30 hover:bg-white/50 text-white rounded-full p-2 backdrop-blur-md"
    >
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
      </svg>
      <span class="sr-only">Próximo</span>
    </button>
  </section>
</template>
<script setup lang="ts">
import {ref, onMounted} from 'vue'
import EmblaCarousel from 'embla-carousel'
import Autoplay from 'embla-carousel-autoplay'

import BannerAbstract from '@/assets/img/banner/banner-abstract.jpeg'
import BannerMatrix from '@/assets/img/banner/banner-matrix.jpeg'

const viewport = ref<HTMLElement | null>(null)
const embla = ref<ReturnType<typeof EmblaCarousel> | null>(null)

const scrollPrev = () => embla.value?.scrollPrev()
const scrollNext = () => embla.value?.scrollNext()

const slides = ref([
  {
    image: BannerAbstract,
    title: 'Descubra',
    subtitle: 'Os melhores filmes de todos os tempos em um só lugar',
  },
  {
    image: BannerMatrix,
    title: 'Explore',
    subtitle: 'Um catálogo completo de clássicos e lançamentos',
  },
])

onMounted(() => {
  if (viewport.value) {
    embla.value = EmblaCarousel(
        viewport.value,
        {loop: true, align: 'center'},
        [Autoplay({delay: 4000, stopOnInteraction: false})]
    )
  }
})
</script>
<style scoped>
.embla__slide {
  flex: 0 0 100%;
  position: relative;
}
</style>
