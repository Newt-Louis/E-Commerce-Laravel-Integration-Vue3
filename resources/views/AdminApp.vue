<template>
  <div class="row" v-if="isLoggin">
    <div class="col-lg-2"><AdminSideBar /></div>
    <div class="col-lg-10">
      <header><AdminHeader /></header>
      <main>
        <router-view></router-view>
      </main>
      <footer>
        <AdminFooter />
      </footer>
    </div>
  </div>
  <router-view name="login" v-else></router-view>
</template>

<script>
import { useAdminUserStore } from "../js/Admin/piniaStores/userAdminStore.js";
import AdminFooter from "./Admin/Layouts/AdminFooter.vue";
import AdminHeader from "./Admin/Layouts/AdminHeader.vue";
import AdminSideBar from "./Admin/Layouts/AdminSideBar.vue";
export default {
  data() {
    return {};
  },
  computed: {
    isLoggin() {
      const userStore = useAdminUserStore();
      return userStore.isLoggin;
    },
  },
  methods: {},
  watch: {},
  mounted() {},
  components: {
    AdminHeader,
    AdminFooter,
    AdminSideBar,
  },
};
</script>

<style scoped></style>
