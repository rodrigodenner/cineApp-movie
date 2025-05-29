<template>
  <div class="fixed inset-0 z-50 bg-black/60 flex items-center justify-center">
    <div class="bg-zinc-900 border border-red-500 p-6 rounded-xl w-full max-w-sm text-white text-center">
      <h2 class="text-xl font-bold text-red-500 mb-2">Excluir Conta</h2>
      <p class="text-sm text-zinc-400 mb-6">
        Tem certeza que deseja excluir sua conta? Esta ação não pode ser desfeita.
      </p>

      <div class="flex justify-center gap-4">
        <button
            @click="$emit('cancel')"
            class="px-4 py-2 text-sm rounded bg-zinc-800 hover:bg-zinc-700 cursor-pointer"
        >
          Cancelar
        </button>
        <button
            @click="$emit('confirm')"
            :disabled="loading"
            class="px-4 py-2 text-sm rounded bg-red-600 hover:bg-red-700 text-white flex items-center justify-center cursor-pointer"
        >
          <svg
              v-if="loading"
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
          <span>{{ loading ? 'Excluindo...' : 'Sim, excluir' }}</span>
        </button>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
defineProps<{
  loading?: boolean
}>()

defineEmits(['cancel', 'confirm'])
</script>
