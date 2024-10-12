import { defineStore } from "pinia";

export const useAdminUserStore = defineStore("adminUser", {
  state: () => {
    return {
      isLogin: false,
      userToken: "",
      adminUser: {},
    };
  },
  getters: {
    checkLogin: (state) => state.isLogin,
    getAdminUser: (state) => state.adminUser,
  },
  actions: {
    setAdminUser(data) {
      this.adminUser = data;
    },
    setLogin() {
      this.isLogin = true;
    },
    setLogout() {
      this.isLogin = false;
    },
  },
});
