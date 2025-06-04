<template>
  <div v-if="movie" class="max-w-7xl mx-auto px-4 my-10">
    <h2 class="text-xl font-bold mb-4">🎞️ Detalhes da Produção</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm text-zinc-300">
      <div><strong class="text-white">Duração:</strong> {{ movie.runtime || 0 }} min</div>
      <div><strong class="text-white">Lançamento:</strong> {{ movie.release_date }}</div>
      <div>
        <strong class="text-white">Idioma Original:</strong>
        {{ movie.original_language?.toUpperCase() }}
      </div>

      <div v-if="movie.production_countries?.length">
        <strong class="text-white">País:</strong>
        {{ movie.production_countries.map((c) => c.name).join(', ') }}
      </div>

      <div v-if="movie.budget">
        <strong class="text-white">Orçamento:</strong>
        US$ {{ movie.budget.toLocaleString() }}
      </div>

      <div v-if="movie.revenue">
        <strong class="text-white">Bilheteria:</strong>
        US$ {{ movie.revenue.toLocaleString() }}
      </div>

      <div v-if="movie.production_companies?.length">
        <strong class="text-white">Produtora(s):</strong>
        {{ movie.production_companies.map((c) => c.name).join(', ') }}
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
interface Company {
  name: string
}

interface Country {
  name: string
}

interface MovieDetails {
  runtime: number | null
  release_date: string
  original_language: string
  production_countries: Country[]
  production_companies: Company[]
  budget: number
  revenue: number
}

defineProps<{
  movie: MovieDetails
}>()
</script>
