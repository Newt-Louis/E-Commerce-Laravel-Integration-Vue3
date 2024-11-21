<template>
  <div>
    <input
      type="password"
      :class="`form-control ${isValidation}`"
      :value="confirmPassword"
      @input="checkPasswordConfirm"
      @focus="hasFocused = true"
      @blur="hasFocused = false"
      placeholder="Confirm Password"
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
    confirmPassword: {
      type: String,
      default: "",
    },
    required: {
      type: Boolean,
      default: false,
    },
  },
  emits: ["confirmPasswordValid", "update:confirmPassword"],
  data() {
    return {
      hasFocused: false,
      isConfirmPasswordValid: {
        name: "confirmpassword",
        isValid: false,
      },
      isValidation: "",
    };
  },
  computed: {
    isPasswordConfirmed() {
      if (this.confirmPassword === "") {
        return { isValid: false, isValidation: "" };
      } else {
        if (this.confirmPassword !== this.password) {
          return { isValid: false, isValidation: "is-invalid" };
        } else {
          return { isValid: true, isValidation: "is-valid" };
        }
      }
    },
  },
  watch: {
    isPasswordConfirmed: {
      handler(newVal) {
        this.isConfirmPasswordValid.isValid = newVal.isValid;
        this.isValidation = newVal.isValidation;
        this.$emit("confirmPasswordValid", this.isConfirmPasswordValid);
      },
      immediate: true,
    },
    // confirmPassword: {
    //   hanlder(newVal) {
    //     if (newVal === "") {
    //       return { isValid: false, isValidation: "" };
    //     } else {
    //       if (newVal !== this.password) {
    //         return { isValid: false, isValidation: "is-invalid" };
    //       } else {
    //         return { isValid: true, isValidation: "is-valid" };
    //       }
    //     }
    //   },
    // },
  },
  mounted() {
    this.$emit("confirmPasswordValid", this.isConfirmPasswordValid);
  },
  methods: {
    checkPasswordConfirm(event) {
      this.$emit("update:confirmPassword", event.target.value);
      return this.$emit("confirmPasswordValid", this.isConfirmPasswordValid);
    },
  },
};
</script>

<style></style>
