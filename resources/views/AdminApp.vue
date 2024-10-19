<template>
  <Authentication />
  <div class="d-flex flex-column" v-if="checkLogin">
    <div :class="`alert alert-danger animate__animated ${rtAlert.alertAnimate}`" role="alert" v-if="rtAlert.isAlert">
      {{ rtAlert.messageError }}
    </div>
    <header class=""><AdminHeader /></header>
    <div class="row mt-3 m-0 main-container">
      <div class="col-lg-2">
        <AdminSideBar />
      </div>
      <div class="col-lg-10 border border-light-subtle rounded p-3">
        <main>
          <router-view></router-view>
        </main>
      </div>
    </div>
    <footer class="mt-3">
      <AdminFooter />
    </footer>
  </div>
  <router-view name="login" v-else></router-view>
</template>

<script>
import { useAdminUserStore } from "~js/Admin/piniaStores/userAdminStore.js";
import { mapState, mapActions } from "pinia";
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
    return {
      refreshToken: null,
      rtAlert: {
        messageError: "",
        isAlert: false,
        alertAnimate: "",
      },
    };
  },
  computed: {
    ...mapState(useAdminUserStore, ["checkLogin"]),
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
  mounted() {
    this.refreshToken = setInterval(async () => {
      try {
        const response = await axsIns.get("/api/auth/admin-remember");
        if (response.status === 200) {
          this.setLogin();
          this.setAdminUser(response.data);
          this.rtAlert.isAlert = false;
          this.rtAlert.messageError = "";
          this.rtAlert.alertAnimate = "";
        }
      } catch (error) {
        this.rtAlert.isAlert = true;
        this.rtAlert.messageError = "Error with connect to internet !!!";
        this.rtAlert.alertAnimate = "animate__fadeInRight";
        console.log(error);
      }
    }, 6600000);
  },
  unmounted() {
    clearInterval(this.refreshToken);
  },
  methods: {
    ...mapActions(useAdminUserStore, ["setAdminUser"]),
    checkstore() {},
  },
};
</script>

<style scoped>
.main-container {
  height: 2400px;
}
.alert {
  position: absolute;
  top: 10px;
  right: 10px;
}
</style>
