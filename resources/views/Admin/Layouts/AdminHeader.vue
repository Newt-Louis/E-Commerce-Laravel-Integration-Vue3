<template>
  <div class="row header-container bg-info-subtle">
    <div class="col-lg-4"><h5>Left Head</h5></div>
    <div class="col-lg-4"><h5>Center Head</h5></div>
    <div class="col-lg-4">
      <div class="d-flex justify-content-end gap-4">
        <div class="">hello username</div>
        <div class="admin-user-setting">
          <i class="fa-solid fa-gears"></i>
        </div>
        <div class="admin-user-logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },
  computed: {},
  mounted() {},
  watch: {},
  methods: {
    async logout() {
      let response;
      try {
        response = await axios.post("/api/admin-user/logout");
      } catch (error) {
        console.log(error);
      }
      // if (response?.data === 200) {

      // }
    },
  },
};
</script>

<style>
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
