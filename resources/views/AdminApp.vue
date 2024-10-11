<template>
  <header class="position-relative top-0"><AdminHeader /></header>
  <div class="row" style="height: 2000px">
    <div class="col-lg-2">
      <AdminSideBar />
      <button @click="checkstore">check</button>
      <p>{{ getAdminUser }}</p>
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
</template>

<script>
import { useAdminUserStore } from "../js/Admin/piniaStores/userAdminStore.js";
import { mapState, mapActions } from "pinia";
import AdminFooter from "./Admin/Layouts/AdminFooter.vue";
import AdminHeader from "./Admin/Layouts/AdminHeader.vue";
import AdminSideBar from "./Admin/Layouts/AdminSideBar.vue";
export default {
  components: {
    AdminHeader,
    AdminFooter,
    AdminSideBar,
  },
  data() {
    return {};
  },
  computed: {
    ...mapState(useAdminUserStore, ["getAdminUser", "checkLoggin"]),
  },
  methods: {
    ...mapActions(useAdminUserStore, ["setIsLoggin", "setAdminUser"]),
    checkstore() {},
  },
  watch: {},
  mounted() {
    console.log(this.checkLoggin);
  },
};
</script>

<style scoped></style>
