import {computed} from 'vue'
import {useAuthStore} from '@/stores/auth'
import {
  login,
  updateUser as apiUpdateUser,
  deleteUser as apiDeleteUser
} from '@/services/authService'

export const useAuth = () => {
  const authStore = useAuthStore()

  const loginUser = async (
      email: string,
      password: string
  ): Promise<{ success: boolean; error?: string }> => {
    try {
      const response = await login(email, password)
      const {token, user} = response.data
      authStore.setSession(token, user)
      return {success: true}
    } catch (error: any) {
      const msg = error?.response?.data?.message || 'Ocorreu um erro ao tentar fazer login.'
      return {success: false, error: msg}
    }
  }

  const updateUser = async (payload: {
    name: string
    email: string
    new_password?: string
    new_password_confirmation?: string
  }): Promise<{ success: boolean; error?: string }> => {
    try {
      const response = await apiUpdateUser(payload)
      const updatedUser = response.data

      if (updatedUser) {
        authStore.setSession(authStore.token, updatedUser)
      }

      return {success: true}
    } catch (error: any) {
      const msg = error?.response?.data?.message || 'Erro ao atualizar perfil.'
      return {success: false, error: msg}
    }
  }

  const deleteUser = async (): Promise<{ success: boolean; error?: string }> => {
    try {
      await apiDeleteUser()
      authStore.logout()
      return {success: true}
    } catch (error: any) {
      const msg = error?.response?.data?.message || 'Erro ao excluir conta.'
      return {success: false, error: msg}
    }
  }

  return {
    loginUser,
    updateUser,
    deleteUser,
    isAuthenticated: computed(() => authStore.isAuthenticated),
    user: computed(() => authStore.user),
  }
}
