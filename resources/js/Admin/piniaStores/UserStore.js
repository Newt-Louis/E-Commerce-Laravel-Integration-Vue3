import { defineStore } from 'pinia'

export const useUserStore = defineStore('users',{
  state: () => {
    return {
      isLoggin: false,
      userToken: '',
    }
  },
  getters: {
    checkIsLoggin: (state) => {state.isLoggin}
  },
  actions: {
    async loggin(){
      this.isLoggin = !this.isLoggin;
    }
  }
})