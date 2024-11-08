<template>
  <input type="text" :class="`form-control ${isValidation}`" :placeholder="placeholder" v-model="displayValue" />
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
      default: "",
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
      isValidation: "",
      isNumberValid: {
        name: this.numberInputName,
        isValid: false,
        value: this.modelValue,
      },
    };
  },
  computed: {
    displayValue: {
      get() {
        // const result = this.modelValue.trim();
        // return result.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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
    isNumberInputDone(event) {
      this.$emit("update:modelValue", event.target.value);
      return this.$emit("numberValid", this.isNumberValid);
    },
  },
};
</script>

<style></style>
