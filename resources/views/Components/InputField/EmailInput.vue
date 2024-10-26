<template>
  <div>
    <input
      :class="`form-control ${isValidation}`"
      type="text"
      placeholder="Email"
      :value="emailEditValue"
      @input="validated"
    />
    <div class="invalid-feedback" v-if="displayError.required">Please input your email !</div>
    <div class="invalid-feedback" v-if="displayError.isInValid">Invalid email !</div>
  </div>
</template>

<script>
import { getValidator } from "~composable/validateInputRules.composable";
export default {
  props: {
    emailEditValue: String,
  },
  emits: ["emailValid", "update:emailEditValue"],
  data() {
    return {
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
    async validated(event) {
      this.$emit("update:emailEditValue", event.target.value);
      this.displayError.required = event.target.value === "";
      const result = await getValidator("email", { value: event.target.value });
      this.isValidation = result ? "is-valid" : "is-invalid";
      this.displayError.isInValid = !result;
      if (result) {
        this.isEmailValid.isValid = true;
        this.isEmailValid.value = event.target.value;
        this.$emit("emailValid", this.isEmailValid);
      }
    },
  },
};
</script>

<style></style>
