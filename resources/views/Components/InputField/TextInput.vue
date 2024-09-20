<template>
  <BaseInput type="text" v-model="textValue" v-bind="$attrs" @bi-valid="declareTextInput">
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
  emits: ["textValid"],
  data() {
    return {
      textValue: "",
      isTextValid: {
        name: "text",
        isValid: false,
      },
    };
  },
  computed: {},
  watch: {},
  mounted() {
    this.$emit("textValid", this.isTextValid);
  },
  methods: {
    checkValue() {
      console.log(this.passwordInput);
    },
    declareTextInput(data) {
      if (data?.baseValid === true) {
        this.isTextValid.isValid = true;
        return this.$emit("textValid", this.isTextValid);
      }
      return this.$emit("textValid", this.isTextValid);
    },
    validateRules() {},
  },
};
</script>

<style></style>
