<template>
  <div class="base-input" v-if="!typeNumber">
    <input
      type="text"
      :class="`form-control ${isValidation}`"
      :value="value"
      :placeholder="placeholder"
      @input="isBaseInputDone"
    />
    <slot name="required" v-if="displayError.required"></slot>
    <slot name="minlength" v-if="displayError.minlength"></slot>
    <slot name="maxlength" v-if="displayError.maxlength"></slot>
    <slot name="pattern" v-if="displayError.pattern"></slot>
  </div>
  <div class="base-input" v-else>
    <input
      type="text"
      :class="`form-control ${isValidation}`"
      v-model="formattedNumber"
      :placeholder="placeholder"
      @input="isNumberInputDone"
      v-bind="$attrs"
    />
    <slot name="required" v-if="displayError.required"></slot>
    <slot name="minlength" v-if="displayError.minlength"></slot>
    <slot name="maxlength" v-if="displayError.maxlength"></slot>
    <slot name="pattern" v-if="displayError.pattern"></slot>
  </div>
</template>

<script>
import { useUtilities } from "~composable/utilities.composable";
import { getValidator } from "~composable/validateInputRules.composable";
export default {
  props: {
    typeNumber: {
      type: Boolean,
      default: false,
    },
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
    inputValue: {
      type: String,
      default: "",
    },
  },
  emits: ["biValid", "update:inputValue"],
  data() {
    return {
      valueTyping: "",
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
      formattedNumber: "",
      numberValue: "",
    };
  },
  computed: {
    value: {
      get() {
        return this.inputValue;
      },
      set(value) {
        this.$emit("update:inputValue", value);
      },
    },
  },
  watch: {
    valueTyping(newVal) {
      this.validateRules(newVal);
    },
    inputValue(newVal) {
      this.validateRules(newVal);
    },
    formattedNumber(newVal) {
      if (newVal) {
        if (newVal !== "") {
          const { numberWithCommas } = useUtilities();

          const cleanedValue = newVal.replace(/[^0-9]/g, "");
          this.numberValue = parseInt(cleanedValue, 10);
          this.formattedNumber = numberWithCommas(cleanedValue);
        }
        this.validateRules();
      } else {
        this.validateRules();
      }
    },
  },

  mounted() {},
  methods: {
    checkRules() {
      const enabledRules = [];
      if (this.required) enabledRules.push("required");
      if (this.minlength > 0) enabledRules.push("minlength");
      if (this.maxlength > 0) enabledRules.push("maxlength");
      if (this.pattern !== "") enabledRules.push("pattern");
      return enabledRules;
    },
    validateRules(valueToValid) {
      const enabledRules = this.checkRules();

      enabledRules.forEach((rule) => {
        const params = this.typeNumber
          ? { value: this.formattedNumber, additionalArgs: [this[rule]] }
          : { value: valueToValid, additionalArgs: [this[rule]] };
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
    isBaseInputDone(event) {
      const baseInputValid = { baseValid: false };
      this.validateRules(event.target.value);
      if (this.isValidation === "is-valid") {
        baseInputValid.baseValid = true;
        return this.$emit("biValid", baseInputValid);
      }
    },
    isNumberInputDone() {
      const baseNumberInputValid = { baseValid: false, numberValue: this.numberValue };
      if (this.isValidation === "is-valid") {
        baseNumberInputValid.baseValid = true;
        return this.$emit("biValid", baseNumberInputValid);
      }
    },
  },
};
</script>

<style scoped></style>
