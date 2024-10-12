<template>
  <div></div>
</template>

<script>
import axios from "axios";
import { useAdminUserStore } from "../../js/Admin/piniaStores/userAdminStore";
import { mapState, mapActions } from "pinia";
export default {
  data() {
    return {};
  },
  computed: {
    ...mapState(useAdminUserStore, ["getAdminUser", "checkLogin"]),
  },
  watch: {},
  async created() {
    try {
      const response = await axios.get("/api/auth/admin-remember");
      if (response.status === 200) {
        this.setLogin();
        this.setAdminUser(response.data.adminUser);
        const token = response.data.adminToken;
        sessionStorage.setItem("temporary_token", token);
        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
        console.log(response.data);

        this.$router.push({ name: "admin-homepage" });
      }
    } catch (error) {
      if (!error.response?.data?.isRemember) {
        this.$router.push({ name: "login-admin" });
      }
    }
  },
  methods: {
    ...mapActions(useAdminUserStore, ["setAdminUser", "setLogin"]),
  },
};
</script>

<style></style>
