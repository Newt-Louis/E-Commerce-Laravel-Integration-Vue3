<template>
  <div class="base-input">
    <input
      :id="idValue"
      type="text"
      :class="`form-control ${isValidation}`"
      :placeholder="placeholder"
      :value="inputValue"
      @input="isTextInputDone"
      @focus="hasFocused = true"
      @blur="hasFocused = false"
    />
    <div class="invalid-feedback" v-if="displayError.required">
      <slot name="required"></slot>
    </div>
    <div class="invalid-feedback" v-if="displayError.minlength">
      <slot name="minlength"></slot>
    </div>
    <div class="invalid-feedback" v-if="displayError.maxlength">
      <slot name="maxlength"></slot>
    </div>
    <div class="invalid-feedback" v-if="displayError.pattern">
      <slot name="pattern"></slot>
    </div>
  </div>
</template>
<script>
import { getValidator } from "~composable/validateInputRules.composable";
export default {
  props: {
    idValue: String,
    textInputName: {
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
      default: "",
    },
    inputValue: {
      type: String,
      default: "",
    },
    validateState: {
      type: Boolean,
      default: true,
    },
  },
  emits: ["textValid", "update:inputValue"],
  data() {
    return {
      hasFocused: false,
      isValidation: "",
      validationResults: {
        required: null,
        minlength: null,
        maxlength: null,
        pattern: null,
      },
      isTextValid: {
        name: this.textInputName,
        isValid: false,
        value: "",
      },
      displayError: {
        required: false,
        minlength: false,
        maxlength: false,
        pattern: false,
      },
    };
  },
  computed: {},
  watch: {
    inputValue: {
      handler(newVal) {
        this.validateRules(newVal);
      },
    },
    validateState: {
      handler(newVal) {
        if (newVal === false) {
          this.isValidation = "";
        }
      },
    },
  },
  mounted() {
    this.$emit("textValid", this.isTextValid);
  },
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
      if (this.inputValue !== "") {
        const enabledRules = this.checkRules();

        enabledRules.forEach((rule) => {
          const params = { value: valueToValid, additionalArgs: [this[rule]] };
          this.validationResults[rule] = getValidator(rule, params);
          this.displayError[rule] = !this.validationResults[rule];
        });

        if (enabledRules.length > 0) {
          const checkIsValid = Object.values(this.validationResults).some((value) => value === false);
          if (checkIsValid) {
            this.isTextValid.isValid = false;
            this.isTextValid.value = valueToValid;
            return (this.isValidation = "is-invalid");
          } else {
            this.isTextValid.isValid = true;
            this.isTextValid.value = valueToValid;
            return (this.isValidation = "is-valid");
          }
        } else {
          return (this.isValidation = "");
        }
      } else {
        if (this.hasFocused) {
          const enabledRules = this.checkRules();
          enabledRules.forEach((rule) => {
            const params = { value: valueToValid, additionalArgs: [this[rule]] };
            this.validationResults[rule] = getValidator(rule, params);
            this.displayError[rule] = !this.validationResults[rule];
          });

          if (enabledRules.length > 0) {
            const checkIsValid = Object.values(this.validationResults).some((value) => value === false);
            if (checkIsValid) {
              this.isTextValid.isValid = false;
              this.isTextValid.value = valueToValid;
              return (this.isValidation = "is-invalid");
            } else {
              this.isTextValid.isValid = true;
              this.isTextValid.value = valueToValid;
              return (this.isValidation = "is-valid");
            }
          } else {
            return (this.isValidation = "");
          }
        }
      }
    },
    isTextInputDone(event) {
      this.$emit("update:inputValue", event.target.value);
      this.validateRules(event.target.value);
      this.$emit("textValid", this.isTextValid);
    },
  },
};
</script>
<style>
.base-input {
  width: 100%;
}
</style>
