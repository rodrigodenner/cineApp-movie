<script setup lang="ts">
import AuthModals from '@/components/auth-modals/Index.vue'
import { useRouter } from 'vue-router'
import { computed, onMounted } from 'vue'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const authStore = useAuthStore()

onMounted(() => {
  authStore.loadFromStorage()
})

const isLoggedIn = computed(() => authStore.isAuthenticated)
const userName = computed(() => authStore.user?.name || 'Usuário')

function logout() {
  authStore.logout()
  router.push('/')
}
</script>

<template>
  <nav class="fixed top-0 w-full z-50 bg-zinc-900 border-b border-zinc-800">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-16">
      <div
          class="flex items-center space-x-2 cursor-pointer"
          @click="router.push({ name: 'home' })"
      >
        <span class="text-red-500 text-2xl">🎬</span>
        <span class="text-red-500 text-xl font-bold">CineApp</span>
      </div>


      <input
          type="text"
          placeholder="Buscar filmes..."
          class="w-full max-w-md bg-zinc-800 text-sm text-white px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
      />

      <div v-if="isLoggedIn" class="flex items-center gap-2 text-white">
        <button
            @click="router.push('/profile')"
            class="flex items-center gap-1 text-sm px-3 py-1 rounded-md hover:bg-red-600 transition-colors cursor-pointer"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5.121 17.804A10.015 10.015 0 0112 15c2.21 0 4.252.716 5.879 1.927M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          {{ userName }}
        </button>

        <button @click="logout">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hover:text-red-500" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H5a3 3 0 01-3-3V7a3 3 0 013-3h5a3 3 0 013 3v1" />
          </svg>
        </button>
      </div>

      <div v-else>
        <AuthModals />
      </div>
    </div>
  </nav>
</template>
