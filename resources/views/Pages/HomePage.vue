<template>
  <div class="container">
    <h1>Trang Chủ Client</h1>
    <button @click="gotoAbout">let's go</button>
  </div>
</template>

<script>
export default {
  components: {},
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
};
</script>

<style></style>
