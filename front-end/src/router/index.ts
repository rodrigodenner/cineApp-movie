import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/home/HomeView.vue'
import { useAuthStore } from '@/stores/auth'

import type { NavigationGuardNext, RouteLocationNormalized } from 'vue-router'

const requireAuth = (
    to: RouteLocationNormalized,
    from: RouteLocationNormalized,
    next: NavigationGuardNext
) => {
  const authStore = useAuthStore()
  if (!authStore.isAuthenticated) {
    return next({ name: 'home' })
  }
  next()
}

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView,
  },
  {
    path: '/profile',
    name: 'profile',
    component: () => import('@/views/profile/ProfileView.vue'),
    beforeEnter: requireAuth,
  },
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

export default router
