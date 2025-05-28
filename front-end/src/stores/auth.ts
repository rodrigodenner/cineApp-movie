import { defineStore } from 'pinia'

interface User {
  id: number
  name: string
  email: string
}

export const useAuthStore = defineStore('auth', {
  state: () => ({
    token: localStorage.getItem('token') || '',
    user: undefined as User | undefined,
    isAuthenticated: !!localStorage.getItem('token'),
  }),
  actions: {
    setSession(token: string, user: User) {
      this.token = token
      this.user = user
      this.isAuthenticated = true
      localStorage.setItem('token', token)
      localStorage.setItem('user', JSON.stringify(user))
    },
    loadFromStorage() {
      const storedUser = localStorage.getItem('user')
      const storedToken = localStorage.getItem('token')

      if (storedUser && storedToken) {
        this.user = JSON.parse(storedUser)
        this.token = storedToken
        this.isAuthenticated = true
      }
    },
    logout() {
      this.token = ''
      this.user = undefined
      this.isAuthenticated = false
      localStorage.removeItem('token')
      localStorage.removeItem('user')
    },
  },
})
