<template>
  <div class="row header-container bg-info-subtle m-0">
    <div class="col-lg-4 d-flex justify-content-start gap-4 user-facade">
      <!-- <img src="" alt="Avatar" /> -->
      <img src="/blank_avatar.jpg" alt="Blank Avatar" />
      <h5>{{ getAdminUser.name }}</h5>
    </div>
    <div class="col-lg-4 d-flex justify-content-evenly gap-4">
      <div><span>System Help</span></div>
      <div><span>Call Support</span></div>
    </div>
    <div class="col-lg-4 d-flex justify-content-end gap-4">
      <div><span>Change theme color</span></div>
      <div class="admin-user-setting">
        <i class="fa-solid fa-gears"></i>
      </div>
      <div class="admin-user-logout" @click="logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { mapActions, mapState } from "pinia";
import { useAdminUserStore } from "~js/Admin/piniaStores/userAdminStore";
export default {
  data() {
    return {};
  },
  computed: {
    ...mapState(useAdminUserStore, ["getAdminUser", "checkLogin"]),
  },
  mounted() {},
  watch: {},
  methods: {
    ...mapActions(useAdminUserStore, ["setAdminUser", "setLogout"]),
    async logout() {
      let response;
      try {
        response = await axios.post("/api/admin-user/logout");
        if (response.status === 200) {
          this.setLogout();
          this.setAdminUser({});
          await this.$router.replace({ name: "login-admin" });
        }
      } catch (error) {
        console.log(error);
      }
    },
  },
};
</script>

<style>
.user-facade {
  width: 100%;
  height: 100%;
  position: inherit;
}
.user-facade > img {
  object-fit: contain;
  border-radius: 50%;
}
.header-container {
  padding: 12px 24px 12px 24px;
  height: 50px;
}
.admin-user-setting:hover {
  cursor: pointer;
  transform: translate(-2px, -2px);
}
.admin-user-setting:active {
  transform: translate(0px, 0px);
}
.admin-user-logout:hover {
  cursor: pointer;
  transform: translate(-2px, -2px);
}
.admin-user-logout:active {
  transform: translate(0px, 0px);
}
</style>
