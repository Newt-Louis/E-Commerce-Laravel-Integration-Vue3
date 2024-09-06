<template>
  <input
    type="text"
    :class="`form-control ${isValidation}`"
    v-model="inputValue"
    @input="validateRules"
  />
  <slot name="required"></slot>
  <slot name="minlength"></slot>
  <slot name="maxlength"></slot>
  <slot name="pattern"></slot>
  <slot name="email"></slot>
  <button @click="checkValue">Check</button>
</template>

<script>
import {
  required,
  minlength,
  maxlength,
  pattern,
  email,
} from "../../js/Admin/Composable/validateInputRules";
export default {
  props: {
    required: {
      type: Boolean,
      default: false,
    },
    minlength: {
      type: Number,
      default: 0,
    },
    maxlength: {
      type: Number,
      default: 0,
    },
    pattern: {
      type: String,
      default: "",
    },
    email: {
      type: String,
      default: "",
    },
  },
  data() {
    return {
      inputValue: "",
      isValidation: "",
    };
  },
  methods: {
    checkValue() {
      console.log(this.inputValue);
      console.log(this.required);
    },
    validateRules() {
      const validationResults = {
        requiredValid: this.required ? required(this.inputValue) : null,
        minlengthValid:
          this.minlength !== 0
            ? minlength(this.inputValue, this.minlength)
            : null,
        maxlengthValid:
          this.maxlength !== 0
            ? maxlength(this.inputValue, this.maxlength)
            : null,
        patternValid:
          this.pattern !== "" ? pattern(this.inputValue, this.pattern) : null,
        emailValid: this.email !== "" ? email(this.inputValue) : null,
      };
      const isRulesOn = Object.values(validationResults).some(
        (result) => result !== null
      );
      if (!isRulesOn) {
        return (this.isValidation = "");
      }
      console.log(Object.values(validationResults));

      const hasInvalidRule = Object.values(validationResults).some(
        (result) => result === false
      );
      this.isValidation = hasInvalidRule ? "is-invalid" : "is-valid";
      return this.isValidation;
    },
  },
};
</script>

<style></style>
