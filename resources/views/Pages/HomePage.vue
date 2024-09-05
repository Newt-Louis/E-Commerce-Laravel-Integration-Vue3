<template>
  <div class="container">
    <h1>Trang Chủ Client</h1>
    <button @click="gotoAbout">let's go</button>
    <ValidateInput />
  </div>
</template>

<script>
import ValidateInput from "../Components/ValidateInput.vue";

export default {
  methods: {
    gotoAbout() {
      this.$router.push("/about");
    },
  },
  components: {
    ValidateInput,
  },
};
</script>

<style></style>
