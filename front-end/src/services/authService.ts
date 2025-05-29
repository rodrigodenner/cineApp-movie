import axios from 'axios'
import router from '@/router'
import { useAuthStore } from '@/stores/auth'

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
})

api.interceptors.request.use((config) => {
  const token = localStorage.getItem('token')
  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }
  return config
})

api.interceptors.response.use(
    response => response,
    error => {
      if (error.response?.status === 401) {
        const authStore = useAuthStore()
        authStore.logout()
        router.push('/login')
      }
      return Promise.reject(error)
    }
)

export const login = async (email: string, password: string) => {
  return api.post('/auth/login', { email, password })
}

export const register = async (payload: {
  name: string
  email: string
  password: string
  password_confirmation: string
}) => {
  return api.post('/auth/register', payload)
}

export const updateUser = async (payload: { name: string; password?: string; new_password?: string; new_password_confirmation?: string }) => {
  return api.put('/auth/user', payload)
}

export const deleteUser = async () => {
  return api.delete('/auth/user')
}


export default api
