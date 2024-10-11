import { defineStore } from "pinia";

export const useAdminUserStore = defineStore("adminUser", {
  state: () => {
    return {
      isLoggin: false,
      userToken: "",
      adminUser: {},
    };
  },
  getters: {
    checkLoggin: (state) => state.isLoggin,
    getAdminUser: (state) => state.adminUser,
  },
  actions: {
    async loggin() {
      this.isLoggin = !this.isLoggin;
    },
    setAdminUser(data) {
      this.adminUser = data;
    },
    setIsLoggin() {
      this.isLoggin = true;
    },
  },
});
