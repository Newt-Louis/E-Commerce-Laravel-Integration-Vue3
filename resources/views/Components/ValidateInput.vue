<template>
  <input type="text" :class="`form-control ${isValidation}`" v-model="inputValue" @input="validateRules" />
  <slot name="required" v-if="displayError.required"></slot>
  <slot name="minlength" v-if="displayError.minlength"></slot>
  <slot name="maxlength" v-if="displayError.maxlength"></slot>
  <slot name="pattern" v-if="displayError.pattern"></slot>
  <slot name="email" v-if="displayError.email"></slot>
  <button @click="checkValue">Check</button>
</template>

<script>
import { getValidator } from "../../js/Composable/validateInputRules";
// import { useUtilities } from "../../js/Composable/utilities.composable";
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
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      inputValue: "",
      isValidation: "",
      validationResults: {
        required: null,
        minlength: null,
        maxlength: null,
        pattern: null,
        email: null,
      },
      displayError: {
        required: false,
        minlength: false,
        maxlength: false,
        pattern: false,
        email: false,
      },
    };
  },
  methods: {
    checkValue() {
      console.log(this.inputValue);
      console.log(this.required);
      console.log(this.validationResults);
    },
    checkRules() {
      const enabledRules = [];
      if (this.required) enabledRules.push("required");
      if (this.minlength > 0) enabledRules.push("minlength");
      if (this.maxlength > 0) enabledRules.push("maxlength");
      if (this.pattern !== "") enabledRules.push("pattern");
      if (this.email) enabledRules.push("email");
      return enabledRules;
    },
    validateRules() {
      // const { isEmptyObject, checkStringLowerCase } = useUtilities();
      const enabledRules = this.checkRules();

      enabledRules.forEach((rule) => {
        const params = { value: this.inputValue, additionalArgs: [this[rule]] };
        this.validationResults[rule] = getValidator(rule, params);
        this.displayError[rule] = !this.validationResults[rule];
      });
      if (enabledRules.length > 0) {
        const checkIsValid = Object.values(this.validationResults).some((value) => value === false);
        if (checkIsValid) {
          return (this.isValidation = "is-invalid");
        }
        return (this.isValidation = "is-valid");
      } else {
        return (this.isValidation = "");
      }
    },
  },
};
</script>

<style></style>
