<template>
  <div>
    <input
      v-model="inputValue"
      :class="`form-control ${isValidation}`"
      type="text"
      placeholder="Email"
      @input="validated"
    />
    <div class="invalid-feedback" v-if="displayError.required">Please input your email !</div>
    <div class="invalid-feedback" v-if="displayError.isInValid">Invalid email !</div>
  </div>
</template>

<script>
import { getValidator } from "~composable/validateInputRules.composable";
export default {
  props: {},
  emits: ["emailValid"],
  data() {
    return {
      inputValue: "",
      isValidation: "",
      displayError: {
        required: false,
        isInValid: false,
      },
      isEmailValid: {
        name: "email",
        isValid: false,
        value: "",
      },
    };
  },
  computed: {},
  watch: {},
  mounted() {
    this.$emit("emailValid", this.isEmailValid);
  },
  methods: {
    async validated() {
      this.displayError.required = this.inputValue === "";
      const result = await getValidator("email", { value: this.inputValue });
      this.isValidation = result ? "is-valid" : "is-invalid";
      this.displayError.isInValid = !result;
      if (result) {
        this.isEmailValid.isValid = true;
        this.isEmailValid.value = this.inputValue;
        this.$emit("emailValid", this.isEmailValid);
      }
    },
  },
};
</script>

<style></style>
