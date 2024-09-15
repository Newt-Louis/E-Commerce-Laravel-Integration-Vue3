<template>
  <div class="container">
    <h1>Trang Chủ Client</h1>
    <button @click="gotoAbout">let's go</button>
    <ValidateForm></ValidateForm>
  </div>
</template>

<script>
import ValidateForm from "~components/ValidateForm.vue";
export default {
  data() {
    return {
      validInput: "",
    };
  },
  methods: {
    gotoAbout() {
      this.$router.push("/about");
    },
    getEvent() {
      console.log(this.validInput);
    },
  },
  components: {
    ValidateForm,
  },
};
</script>

<style></style>
