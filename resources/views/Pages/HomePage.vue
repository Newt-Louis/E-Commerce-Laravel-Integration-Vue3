<template>
  <div class="container">
    <h1>Trang Chủ Client</h1>
    <button @click="gotoAbout">let's go</button>
    <form action="" novalidate class="mt-5">
      <NumberInput :required="true">
        <template #required>Nhập số</template>
        <template #pattern>Chỉ được nhập số và không bắt đầu bằng 0!</template>
      </NumberInput>
    </form>
  </div>
</template>

<script>
import NumberInput from "../Components/InputField/NumberInput.vue";
export default {
  components: {
    NumberInput,
  },
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
