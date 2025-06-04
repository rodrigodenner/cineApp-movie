import axios from 'axios'
import router from '@/router'
import { useAuthStore } from '@/stores/auth.ts'

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
})

api.interceptors.request.use(config => {
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
        const auth = useAuthStore()
        auth.logout()
        router.push('/login')
      }
      return Promise.reject(error)
    }
)

export default api
