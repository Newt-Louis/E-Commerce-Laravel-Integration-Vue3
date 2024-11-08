<template>
  <div>
    <input
      type="text"
      :class="`form-control ${isValidation}`"
      :placeholder="placeholder"
      v-model="displayValue"
      @input="isNumberInputDone"
      @focus="hasFocused = true"
      @blur="hasFocused = false"
    />
    <div class="invalid-feedback">
      <slot name="required" v-if="displayError.required"></slot>
    </div>
    <div class="invalid-feedback">
      <slot name="minlength" v-if="displayError.minlength"></slot>
    </div>
    <div class="invalid-feedback">
      <slot name="maxlength" v-if="displayError.maxlength"></slot>
    </div>
    <div class="invalid-feedback">
      <span v-if="displayError.pattern">Only number</span>
    </div>
  </div>
</template>

<script>
import { getValidator } from "../../../js/Composable/validateInputRules.composable";
import { useUtilities } from "../../../js/Composable/utilities.composable";
export default {
  components: {},
  props: {
    numberInputName: {
      type: String,
      default: "",
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
      default: "^[0-9.,]+$",
    },
    modelValue: String,
    validateState: {
      type: Boolean,
      default: true,
    },
  },
  emits: ["numberValid", "update:modelValue"],
  data() {
    return {
      hasFocused: false,
      isValidation: "",
      isNumberValid: {
        name: this.numberInputName,
        isValid: false,
        value: "",
      },
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
  computed: {
    displayValue: {
      get() {
        const utilities = useUtilities();
        return utilities.numberWithCommas(this.modelValue);
      },
      set(newValue) {
        const numberValue = newValue.replace(/,/g, "");
        this.$emit("update:modelValue", numberValue);
      },
    },
  },
  watch: {},
  mounted() {
    this.$emit("numberValid", this.isNumberValid);
  },
  methods: {
    checkRules() {
      const enabledRules = [];
      if (this.required) enabledRules.push("required");
      if (this.minlength > 0) enabledRules.push("minlength");
      if (this.maxlength > 0) enabledRules.push("maxlength");

      enabledRules.push("pattern");
      return enabledRules;
    },
    controlEnabledRules(valueToValid) {
      const enabledRules = this.checkRules();
      enabledRules.forEach((rule) => {
        const params = { value: valueToValid, additionalArgs: [this[rule]] };
        this.validationResults[rule] = getValidator(rule, params);
        this.displayError[rule] = !this.validationResults[rule];
      });
      console.log(this.validationResults);

      return enabledRules.length;
    },
    controlValidState(valueToValid) {
      if (this.controlEnabledRules(valueToValid) > 0) {
        const checkIsValid = Object.values(this.validationResults).some((value) => value === false);
        this.isNumberValid.isValid = !checkIsValid;
        this.isNumberValid.value = valueToValid;
        return (this.isValidation = !checkIsValid ? "is-valid" : "is-invalid");
      } else {
        return (this.isValidation = "");
      }
    },
    validateRules(valueToValid) {
      if (valueToValid !== "") {
        this.controlValidState(valueToValid);
      } else {
        if (this.hasFocused) {
          this.controlValidState(valueToValid);
        }
      }
    },
    isNumberInputDone(event) {
      this.validateRules(event.target.value);
      return this.$emit("numberValid", this.isNumberValid);
    },
  },
};
</script>

<style></style>
