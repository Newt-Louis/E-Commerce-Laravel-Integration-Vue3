<template>
  <BaseInput type="password" v-model="passwordValue" @bi-valid="declarePasswordInput">
    <template #required>
      <div class="invalid-feedback">
        <slot name="required"></slot>
      </div>
    </template>
    <template #minlength>
      <div class="invalid-feedback">
        <slot name="minlength"></slot>
      </div>
    </template>
    <template #maxlength>
      <div class="invalid-feedback">
        <slot name="maxlength"></slot>
      </div>
    </template>
    <template #pattern>
      <div class="invalid-feedback">
        <slot name="pattern"></slot>
      </div>
    </template>
  </BaseInput>
</template>

<script>
import BaseInput from "./BaseInput.vue";
export default {
  components: {
    BaseInput,
  },
  props: {},
  emits: ["passwordValid", "emitPasswordStatus"],
  data() {
    return {
      passwordValue: "",
      isPasswordValid: {
        name: "password",
        isValid: false,
        value: "",
      },
    };
  },
  computed: {
    passwordStatus() {
      return {
        isValid: this.isPasswordValid.isValid,
        passwordValue: this.passwordValue,
      };
    },
  },
  watch: {
    passwordStatus: {
      deep: true,
      handler(newStatus) {
        if (newStatus.isValid) {
          this.$emit("emitPasswordStatus", newStatus);
        }
      },
    },
  },
  mounted() {
    this.$emit("passwordValid", this.isPasswordValid);
  },
  methods: {
    declarePasswordInput(validationData) {
      // Phương pháp trong comment sử dụng khi một thuộc tính phải kiểm tra hàng loạt điều kiện true thì mới được thành true.
      /*       const validationConditions = [validationData.baseValid];
      this.isPasswordValid.isValid = validationConditions.every((condition) => condition === true); */
      if (validationData?.baseValid === true) {
        this.isPasswordValid.isValid = validationData?.baseValid;
        this.isPasswordValid.value = this.passwordValue;
      }
      return this.$emit("passwordValid", this.isPasswordValid);
    },
  },
};
</script>

<style></style>
