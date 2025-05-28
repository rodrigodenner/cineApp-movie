<script setup lang="ts">
import { ref } from 'vue'
import LoginModal from "@/components/auth-modals/login-modal/LoginModal.vue";
import RegisterModal from "@/components/auth-modals/register-modal/RegisterModal.vue";


const showLogin = ref(false)
const showRegister = ref(false)

const switchToRegister = () => {
  showLogin.value = false
  showRegister.value = true
}

const switchToLogin = () => {
  showRegister.value = false
  showLogin.value = true
}
</script>

<template>
  <div>
    <button @click="showLogin = true" class="bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded">
      Entrar
    </button>

    <LoginModal v-if="showLogin" @close="showLogin = false" @switch-to-register="switchToRegister" />
    <RegisterModal v-if="showRegister" @close="showRegister = false" @switch-to-login="switchToLogin" />
  </div>
</template>
