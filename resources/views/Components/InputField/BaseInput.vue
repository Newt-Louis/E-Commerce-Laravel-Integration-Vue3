<template>
  <div class="base-input">
    <input
      type="text"
      :class="`form-control ${isValidation}`"
      v-model="inputValue"
      :placeholder="placeholder"
      @input="isBaseInputDone"
      v-bind="$attrs"
    />
    <slot name="required" v-if="displayError.required"></slot>
    <slot name="minlength" v-if="displayError.minlength"></slot>
    <slot name="maxlength" v-if="displayError.maxlength"></slot>
    <slot name="pattern" v-if="displayError.pattern"></slot>
  </div>
</template>

<script>
import { getValidator } from "~composable/validateInputRules.composable";
export default {
  props: {
    placeholder: {
      type: String,
      default: "",
    },
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
      },
      displayError: {
        required: false,
        minlength: false,
        maxlength: false,
        pattern: false,
      },
    };
  },
  emits: ["biValid"],
  methods: {
    checkRules() {
      const enabledRules = [];
      if (this.required) enabledRules.push("required");
      if (this.minlength > 0) enabledRules.push("minlength");
      if (this.maxlength > 0) enabledRules.push("maxlength");
      if (this.pattern !== "") enabledRules.push("pattern");
      return enabledRules;
    },
    validateRules() {
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
    isBaseInputDone() {
      const baseInputValid = { baseValid: false };
      if (this.isValidation === "is-valid") {
        baseInputValid.baseValid = true;
        return this.$emit("biValid", baseInputValid);
      }
    },
  },
  watch: {
    inputValue(newVal, oldVal) {
      if (newVal || oldVal) {
        this.validateRules();
      }
    },
  },
  mounted() {},
};
</script>

<style scoped></style>
