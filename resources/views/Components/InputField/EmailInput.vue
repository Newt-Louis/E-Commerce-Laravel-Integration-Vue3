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
import { useValidateStateStore } from "../../../js/piniaStores/validateStateStore";
import { mapState, mapActions } from "pinia";
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
  computed: {
    ...mapState(useValidateStateStore, ["validateState"]),
  },
  watch: {
    emailEditValue: {
      handler(newVal) {
        if (newVal) {
          this.emailValidation(newVal);
        }
      },
    },
    validateState: {
      handler(newVal) {
        if (newVal === true) {
          this.isValidation = "";
        }
      },
    },
  },
  mounted() {
    this.$emit("emailValid", this.isEmailValid);
  },
  methods: {
    ...mapActions(useValidateStateStore, ["turnValidateOff"]),
    emailValidation(valueToValidate) {
      this.displayError.required = valueToValidate === "";
      const result = getValidator("email", { value: valueToValidate });
      if (result) {
        this.isValidation = "is-valid";
        this.isEmailValid.isValid = true;
      } else {
        this.isValidation = "is-invalid";
        this.isEmailValid.isValid = false;
      }
      this.isEmailValid.value = valueToValidate;
      this.displayError.isInValid = !result;
    },
    validated(event) {
      this.$emit("update:emailEditValue", event.target.value);
      this.emailValidation(event.target.value);
      this.$emit("emailValid", this.isEmailValid);
    },
  },
};
</script>

<style></style>
