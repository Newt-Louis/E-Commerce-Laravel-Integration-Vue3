<template>
  <div class="container">
    <h1>Trang Chủ Client</h1>
    <button @click="gotoAbout">let's go</button>
    <ValidateInput :required="true">
      <template #required>
        <div class="invalid-feedback">Input Username !!!</div>
      </template>
    </ValidateInput>
  </div>
</template>

<script>
import ValidateInput from "../Components/ValidateInput.vue";

export default {
  data() {
    return {
      validInput: "is-valid",
    };
  },
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
