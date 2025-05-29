<script setup lang="ts">
import { ref } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useAuth } from '@/composables/useAuth'

const emit = defineEmits(['close', 'switch-to-register'])

const router = useRouter()
const route = useRoute()
const email = ref('')
const password = ref('')
const errorMessage = ref<string | undefined>()

const { loginUser } = useAuth()

const handleLogin = async () => {
  errorMessage.value = ''

  const { success, error } = await loginUser(email.value, password.value)

  if (!success) {
    errorMessage.value = error
    return
  }
  emit('close')

  if (route.name !== 'movie-detail') {
    router.push({ name: 'profile' })
  }
}
</script>




<template>
  <div class="fixed inset-0 z-50 bg-black/60 flex items-center justify-center">
    <div class="bg-zinc-900 p-6 rounded-xl w-full max-w-md border border-zinc-800 relative">
      <button @click="$emit('close')" class="absolute top-2 right-2 text-zinc-400 hover:text-white">&times;</button>
      <div class="text-center mb-6">
        <div class="text-red-500 text-4xl">🎬</div>
        <h2 class="text-2xl font-bold text-white mt-2">Entrar no CineApp</h2>
      </div>
      <form @submit.prevent="handleLogin">
        <div v-if="errorMessage" class="bg-red-600/20 text-red-400 text-sm px-4 py-2 rounded mb-4">
          {{ errorMessage }}
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium mb-1 text-white">Email</label>
          <input v-model="email" type="email" placeholder="seu@email.com"
                 class="w-full bg-zinc-800 text-white px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500" />
        </div>
        <div class="mb-6">
          <label class="block text-sm font-medium mb-1 text-white">Senha</label>
          <input v-model="password" type="password" placeholder="******"
                 class="w-full bg-zinc-800 text-white px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500" />
        </div>
        <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 rounded">
          Entrar
        </button>
      </form>
      <p class="text-center text-sm text-zinc-400 mt-4">
        Não tem uma conta?
        <button @click="$emit('switch-to-register')" class="text-red-500 hover:underline ml-1 cursor-pointer">
          Cadastre-se
        </button>
      </p>
    </div>
  </div>
</template>
