<template>
  <div>
    <button @click="modalStore.showLogin()"
            class="bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded cursor-pointer">
      Entrar
    </button>

    <LoginModal
        v-if="modalStore.loginVisible"
        @close="modalStore.hideLogin"
        @switch-to-register="switchToRegister"
    />

    <RegisterModal
        v-if="showRegister"
        @close="showRegister = false"
        @switch-to-login="switchToLogin"
    />
  </div>
</template>
<script setup lang="ts">

import LoginModal from "@/components/auth-modals/login-modal/LoginModal.vue"
import RegisterModal from "@/components/auth-modals/register-modal/RegisterModal.vue"
import {useModalStore} from "@/stores/useModalStore.ts";
import {ref} from "vue";

const modalStore = useModalStore()
const showRegister = ref(false)

const switchToRegister = () => {
  modalStore.hideLogin()
  showRegister.value = true
}

const switchToLogin = () => {
  showRegister.value = false
  modalStore.showLogin()
}
</script>

