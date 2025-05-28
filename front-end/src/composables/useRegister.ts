import { computed } from 'vue'
import { register } from '@/services/authService'
import { useAuthStore } from '@/stores/auth'

export const useRegister = () => {
  const authStore = useAuthStore()

  const registerUser = async (
      name: string,
      email: string,
      password: string,
      password_confirmation: string
  ): Promise<{ success: boolean; error?: string }> => {
    try {
      const response = await register({ name, email, password, password_confirmation })
      const { token, user } = response.data
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
