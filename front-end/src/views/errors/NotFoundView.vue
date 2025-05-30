<template>
  <div class="min-h-screen flex items-center justify-center text-white bg-zinc-900">
    <div class="text-center">
      <h1 class="text-6xl font-bold text-red-500">404</h1>
      <p class="text-xl mt-2">Página não encontrada</p>
      <router-link
          :to="{ name: 'home' }"
          class="mt-4 inline-block bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700"
      >
        Voltar para o início
      </router-link>
    </div>
  </div>
</template>
