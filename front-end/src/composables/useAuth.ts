import { computed } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { login } from '@/services/authService'

export const useAuth = () => {
  const authStore = useAuthStore()

  const loginUser = async (
      email: string,
      password: string
  ): Promise<{ success: boolean; error?: string }> => {
    try {
      const response = await login(email, password)
      const { token, user } = response.data
      authStore.setSession(token, user)
      return { success: true }
    } catch (error: any) {
      const msg = error?.response?.data?.message || 'Ocorreu um erro ao tentar fazer login.'
      return { success: false, error: msg }
    }
  }

  return {
    loginUser,
    isAuthenticated: computed(() => authStore.isAuthenticated),
    user: computed(() => authStore.user),
  }
}
