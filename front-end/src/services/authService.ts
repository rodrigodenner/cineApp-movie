import axios from 'axios'

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
export default api
