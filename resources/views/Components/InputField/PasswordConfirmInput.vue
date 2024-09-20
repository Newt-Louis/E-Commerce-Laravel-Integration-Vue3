<template>
  <div>
    <input
      type="password"
      :class="`form-control ${isValidation}`"
      v-model="confirmPasswordValue"
      :placeholder="placeholder"
      v-bind="$attrs"
    />
    <div class="invalid-feedback">
      <slot></slot>
    </div>
  </div>
</template>

<script>
export default {
  components: {},
  props: {
    placeholder: String,
    password: String,
  },
  emits: ["confirmPasswordValid", "emitConfirmPasswordStatus"],
  data() {
    return {
      confirmPasswordValue: "",
      isConfirmPasswordValid: {
        name: "confirmpassword",
        isValid: false,
      },
      isValidation: "",
    };
  },
  computed: {
    isPasswordConfirmed() {
      if (this.confirmPasswordValue === "") {
        return { isValid: false, isValidation: "" };
      } else {
        if (this.confirmPasswordValue !== this.password) {
          return { isValid: false, isValidation: "is-invalid" };
        } else {
          return { isValid: true, isValidation: "is-valid" };
        }
      }
    },
  },
  watch: {
    isPasswordConfirmed: {
      immediate: true,
      handler(newVal) {
        this.isConfirmPasswordValid.isValid = newVal.isValid;
        this.isValidation = newVal.isValidation;
        this.$emit("confirmPasswordValid", this.isConfirmPasswordValid);
      },
    },
  },
  mounted() {
    this.$emit("confirmPasswordValid", this.isConfirmPasswordValid);
  },
  methods: {
    checkPasswordConfirm() {
      return this.$emit("confirmPasswordValid", this.isConfirmPasswordValid);
    },
  },
};
</script>

<style></style>
