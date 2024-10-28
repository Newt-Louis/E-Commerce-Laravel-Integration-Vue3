<template>
  <div>
    <input
      type="password"
      :class="`form-control ${isValidation}`"
      :value="inputValue"
      placeholder="Password"
      @input="declarePasswordInput"
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
      <slot name="pattern" v-if="displayError.pattern"></slot>
    </div>
  </div>
</template>

<script>
import { getValidator } from "~composable/validateInputRules.composable";
import { useValidateStateStore } from "../../../js/piniaStores/validateStateStore";
import { mapActions, mapState } from "pinia";
export default {
  components: {},
  props: {
    modelValue: {
      type: String,
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
  emits: ["passwordValid", "update:inputValue"],
  data() {
    return {
      hasFocused: false,
      isValidation: "",
      passwordValue: "",
      isPasswordValid: {
        name: "password",
        isValid: false,
        value: "",
      },
      displayError: {
        required: false,
        minlength: false,
        maxlength: false,
        pattern: false,
      },
      validationResults: {
        required: null,
        minlength: null,
        maxlength: null,
        pattern: null,
      },
    };
  },
  computed: {
    ...mapState(useValidateStateStore, ["validateState"]),
  },
  watch: {
    validateState: {
      handler(newVal) {
        if (newVal === true) {
          this.isValidation = "";
        }
      },
    },
  },
  mounted() {
    this.$emit("passwordValid", this.isPasswordValid);
  },
  methods: {
    ...mapActions(useValidateStateStore, ["turnValidateOff"]),
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
      } else {
        if (this.hasFocused) {
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
            } else {
              this.isPasswordValid.isValid = true;
              this.isPasswordValid.value = valueToValid;
              return (this.isValidation = "is-valid");
            }
          } else {
            return (this.isValidation = "");
          }
        }
      }
    },
    declarePasswordInput(event) {
      this.$emit("update:inputValue", event.target.value);
      this.validateRules(event.target.value);
      this.$emit("passwordValid", this.isPasswordValid);
    },
  },
};
</script>

<style></style>
