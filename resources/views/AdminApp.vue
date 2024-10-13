<template>
  <Authentication />
  <div class="d-flex flex-column" v-if="checkLogin">
    <header class="position-relative top-0"><AdminHeader /></header>
    <div class="row">
      <div class="col-lg-2">
        <AdminSideBar />
      </div>
      <div class="col-lg-10">
        <main>
          <router-view></router-view>
        </main>
      </div>
    </div>
    <footer class="position-relative bottom-0">
      <AdminFooter />
    </footer>
  </div>
  <router-view name="login" v-else></router-view>
</template>

<script>
import { useAdminUserStore } from "~js/Admin/piniaStores/userAdminStore.js";
import { mapState } from "pinia";
import AdminFooter from "./Admin/Layouts/AdminFooter.vue";
import AdminHeader from "./Admin/Layouts/AdminHeader.vue";
import AdminSideBar from "./Admin/Layouts/AdminSideBar.vue";
import Authentication from "~components/Authentication.vue";
import { axsIns } from "../js/bootstrap";
export default {
  components: {
    AdminHeader,
    AdminFooter,
    AdminSideBar,
    Authentication,
  },
  data() {
    return {};
  },
  computed: {
    ...mapState(useAdminUserStore, ["checkLogin"]),
  },
  methods: {
    checkstore() {},
  },
  watch: {},
  async beforeMount() {
    try {
      const csrfToken = await axsIns.get("/sanctum/csrf-cookie");
      if (csrfToken.status === 204) {
        axsIns.defaults.withCredentials = true;
        axsIns.defaults.withXSRFToken = true;
      }
    } catch (error) {
      console.log(error);
    }
  },
  mounted() {},
};
</script>

<style scoped></style>
