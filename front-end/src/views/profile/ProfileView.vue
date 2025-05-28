<script setup lang="ts">
import { useAuthStore } from '@/stores/auth.ts'

const authStore = useAuthStore()
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-zinc-950 text-white px-4">
    <div class="bg-zinc-900 p-8 rounded-xl shadow-lg border border-zinc-800 max-w-md w-full text-center">
      <h1 class="text-3xl font-bold mb-4">👤 Perfil do Usuário</h1>
      <p class="mb-2"><strong>Token:</strong></p>
      <code class="break-words text-xs text-zinc-400">{{ authStore.token }}</code>

      <button
          @click="authStore.logout()"
          class="mt-6 w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 rounded"
      >
        Sair
      </button>
    </div>
  </div>
</template>
