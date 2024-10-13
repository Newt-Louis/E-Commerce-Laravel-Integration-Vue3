<template>
  <div></div>
</template>

<script>
import { useAdminUserStore } from "../../js/Admin/piniaStores/userAdminStore";
import { mapState, mapActions } from "pinia";
import { axsIns } from "../../js/bootstrap";
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
      const response = await axsIns.get("/api/auth/admin-remember");
      if (response.status === 200) {
        this.setLogin();
        this.setAdminUser(response.data.adminUser);
        // const token = response.data.adminToken;
        // sessionStorage.setItem("temporary_token", token);
        // this.$axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
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
