import { computed } from 'vue'
import { useAuthStore } from '@/stores/auth'
import {
  login,
  updateUser as apiUpdateUser,
  deleteUser as apiDeleteUser
} from '@/services/auth/authService'
import type {AuthUser} from "@/types/AuthUser.ts";
import type {UpdateUserPayload} from "@/types/AuthPayloads.ts";


export const useAuth = () => {
  const authStore = useAuthStore()

  const loginUser = async (
      email: string,
      password: string
  ): Promise<{ success: boolean; error?: string }> => {
    try {
      const response = await login(email, password)
      const { token, user } = response.data as { token: string; user: AuthUser }
      authStore.setSession(token, user)
      return { success: true }
    } catch (error: any) {
      const msg = error?.response?.data?.message || 'Ocorreu um erro ao tentar fazer login.'
      return { success: false, error: msg }
    }
  }

  const updateUser = async (
      payload: UpdateUserPayload
  ): Promise<{ success: boolean; error?: string }> => {
    try {
      const response = await apiUpdateUser(payload)
      const updatedUser = response.data as AuthUser

      if (updatedUser) {
        authStore.setSession(authStore.token, updatedUser)
      }

      return { success: true }
    } catch (error: any) {
      const msg = error?.response?.data?.message || 'Erro ao atualizar perfil.'
      return { success: false, error: msg }
    }
  }

  const deleteUser = async (): Promise<{ success: boolean; error?: string }> => {
    try {
      await apiDeleteUser()
      authStore.logout()
      return { success: true }
    } catch (error: any) {
      const msg = error?.response?.data?.message || 'Erro ao excluir conta.'
      return { success: false, error: msg }
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
