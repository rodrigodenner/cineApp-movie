<template>
  <div class="fixed inset-0 z-50 bg-black/60 flex items-center justify-center">
    <div class="bg-zinc-900 p-6 rounded-xl w-full max-w-md border border-zinc-800 relative">
      <button @click="$emit('close')" class="absolute top-2 right-2 text-zinc-400 cursor-pointer hover:text-white">
        &times;
      </button>

      <h2 class="text-2xl font-bold text-white mb-1">Editar Perfil</h2>
      <p class="text-sm text-zinc-400 mb-4">Atualize suas informações pessoais</p>

      <form @submit.prevent="submit">
        <div v-if="errorMessage" class="bg-red-600/20 text-red-400 text-sm px-4 py-2 rounded mb-4">
          {{ errorMessage }}
        </div>

        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-white mb-1">Nome</label>
            <input
                v-model="form.name"
                @input="clearError"
                type="text"
                class="w-full bg-zinc-800 text-white px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-white mb-1">Email</label>
            <input
                v-model="form.email"
                @input="clearError"
                type="email"
                class="w-full bg-zinc-800 text-white px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
            />
          </div>

          <div class="pt-4 border-t border-zinc-800 mt-4">
            <h3 class="text-sm text-zinc-400 mb-2">Alterar Senha</h3>
            <input
                v-model="form.new_password"
                @input="clearError"
                type="password"
                placeholder="Nova Senha"
                class="w-full bg-zinc-800 text-white px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 mb-2"
            />
            <input
                v-model="form.new_password_confirmation"
                @input="clearError"
                type="password"
                placeholder="Confirmar Nova Senha"
                class="w-full bg-zinc-800 text-white px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
            />
          </div>

          <div class="mt-6 border border-red-500 p-4 rounded">
            <p class="text-red-500 font-semibold mb-1">Zona de Perigo</p>
            <p class="text-sm text-zinc-400 mb-2">Esta ação não pode ser desfeita.</p>
            <button
                type="button"
                @click="handleDelete"
                :disabled="isDeleting"
                class="text-sm px-4 py-2 rounded bg-red-600 hover:bg-red-700 cursor-pointer text-white flex items-center justify-center"
            >
              <svg
                  v-if="isDeleting"
                  class="animate-spin h-5 w-5 mr-2 text-white"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
              >
                <circle
                    class="opacity-25"
                    cx="12"
                    cy="12"
                    r="10"
                    stroke="currentColor"
                    stroke-width="4"
                />
                <path
                    class="opacity-75"
                    fill="currentColor"
                    d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 00-8 8h4l-3 3 3 3H4z"
                />
              </svg>
              <span>{{ isDeleting ? 'Excluindo...' : '🗑️ Excluir Conta' }}</span>
            </button>
          </div>
        </div>

        <div class="flex justify-end gap-2 mt-6">
          <button
              type="button"
              @click="$emit('close')"
              :disabled="isSubmitting"
              class="text-sm px-4 py-2 rounded bg-zinc-800 hover:bg-zinc-700 text-white cursor-pointer"
          >
            Cancelar
          </button>
          <button
              type="submit"
              :disabled="isSubmitting"
              class="text-sm px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white cursor-pointer flex items-center justify-center"
          >
            <svg
                v-if="isSubmitting"
                class="animate-spin h-5 w-5 mr-2 text-white"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
            >
              <circle
                  class="opacity-25"
                  cx="12"
                  cy="12"
                  r="10"
                  stroke="currentColor"
                  stroke-width="4"
              />
              <path
                  class="opacity-75"
                  fill="currentColor"
                  d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 00-8 8h4l-3 3 3 3H4z"
              />
            </svg>
            <span>{{ isSubmitting ? 'Salvando...' : 'Salvar Alterações' }}</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useAuth } from '@/composables/useAuth'

const emit = defineEmits(['close'])
const { user, updateUser, deleteUser } = useAuth()

const form = ref({
  name: user.value?.name || '',
  email: user.value?.email || '',
  new_password: '',
  new_password_confirmation: '',
})

const errorMessage = ref('')
const isSubmitting = ref(false)
const isDeleting = ref(false)

const clearError = () => {
  errorMessage.value = ''
}

const submit = async () => {
  clearError()
  isSubmitting.value = true

  const hasNameChanged = form.value.name !== user.value?.name
  const hasEmailChanged = form.value.email !== user.value?.email
  const hasPassword = form.value.new_password !== ''

  if (!hasNameChanged && !hasEmailChanged && !hasPassword) {
    errorMessage.value = 'Nenhuma alteração detectada.'
    isSubmitting.value = false
    return
  }

  if (hasPassword && form.value.new_password !== form.value.new_password_confirmation) {
    errorMessage.value = 'As senhas não coincidem.'
    isSubmitting.value = false
    return
  }

  const payload = {
    name: form.value.name,
    email: form.value.email,
    new_password: hasPassword ? form.value.new_password : undefined,
    new_password_confirmation: hasPassword ? form.value.new_password_confirmation : undefined,
  }

  const { success } = await updateUser(payload)
  isSubmitting.value = false

  if (success) emit('close')
}

const handleDelete = async () => {
  const confirmed = confirm('Tem certeza que deseja excluir sua conta? Essa ação é irreversível.')
  if (!confirmed) return

  isDeleting.value = true
  const { success } = await deleteUser()
  isDeleting.value = false

  if (success) emit('close')
}
</script>
