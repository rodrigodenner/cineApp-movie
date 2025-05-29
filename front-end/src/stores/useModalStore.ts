import {defineStore} from 'pinia'

export const useModalStore = defineStore('modal', {
  state: () => ({
    loginVisible: false
  }),
  actions: {
    showLogin() {
      this.loginVisible = true
    },
    hideLogin() {
      this.loginVisible = false
    }
  }
})