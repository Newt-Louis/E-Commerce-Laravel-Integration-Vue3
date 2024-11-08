<template>
  <div class="container">
    <h1>Trang Chủ Client</h1>
    <button @click="getEvent">let's go</button>
    <form action="" novalidate class="mt-5">
      <NumberInput v-model="validInput"></NumberInput>
      <!-- <input type="text" name="" id="" v-model="validInput" @input="inputHandle" /> -->
    </form>
  </div>
</template>

<script>
import DateInput from "../Components/InputField/DateInput.vue";
import NumberInput from "../Components/InputField/NumberInput.vue";
import { useUtilities } from "../../js/Composable/utilities.composable";
export default {
  components: {
    DateInput,
    NumberInput,
  },
  data() {
    return {
      validInput: "",
      fileValues: [],
    };
  },
  computed: {},
  watch: {},
  methods: {
    gotoAbout() {
      this.$router.push("/about");
    },
    getEvent() {
      console.log(this.validInput);
    },
    inputHandle(data) {
      console.log(data);
    },
  },
};
</script>

<style></style>
