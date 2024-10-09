<template>
  <div class="container">
    <h1>Trang Chủ Client</h1>
    <button @click="gotoAbout">let's go</button>
    <form action="" novalidate class="mt-5">
      <DateInput @dateValid="dateHandle"></DateInput>
    </form>
  </div>
</template>

<script>
import DateInput from "../Components/InputField/DateInput.vue";
export default {
  components: {
    DateInput,
  },
  data() {
    return {
      validInput: "",
      fileValues: [],
    };
  },
  methods: {
    gotoAbout() {
      this.$router.push("/about");
    },
    getEvent() {
      console.log(this.validInput);
    },
    dateHandle(data) {
      console.log(data);
    },
  },
};
</script>

<style></style>
