import { defineStore } from "pinia";

export const useAdminUserStore = defineStore("admin-users", {
  state: () => {
    return {
      isLoggin: false,
      userToken: "",
      adminUser: {},
    };
  },
  getters: {
    checkIsLoggin: (state) => {
      state.isLoggin;
    },
    getAdminUser: () => this.adminUser,
  },
  actions: {
    async loggin() {
      this.isLoggin = !this.isLoggin;
    },
    setAdminUser(data) {
      this.adminUser = data;
    },
  },
});
