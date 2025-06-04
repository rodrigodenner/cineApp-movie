import { computed } from 'vue'
import { register } from '@/services/auth/authService'
import { useAuthStore } from '@/stores/auth'
import type { RegisterPayload } from '@/types/AuthPayloads.ts'
import type { AuthUser } from '@/types/AuthUser.ts'

export const useRegister = () => {
  const authStore = useAuthStore()

  const registerUser = async (
      payload: RegisterPayload
  ): Promise<{ success: boolean; error?: string }> => {
    try {
      const response = await register(payload)
      const { token, user } = response.data as { token: string; user: AuthUser }
      authStore.setSession(token, user)
      return { success: true }
    } catch (error: any) {
      if (error?.response?.status === 422) {
        const errors: Record<string, string[]> = error.response.data.errors
        const firstError = Object.values(errors)[0][0]
        return { success: false, error: firstError }
      }

      const fallback = error?.response?.data?.message || 'Erro ao criar conta.'
      return { success: false, error: fallback }
    }
  }

  return {
    registerUser,
    isAuthenticated: computed(() => authStore.isAuthenticated),
  }
}
