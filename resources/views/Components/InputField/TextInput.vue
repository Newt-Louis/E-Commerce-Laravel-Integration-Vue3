<template>
  <BaseInput type="text" v-model:input-value="textValue" @bi-valid="declareTextInput">
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
  props: {
    textInputName: String,
    parentValue: String,
  },
  emits: ["textValid"],
  data() {
    return {
      isTextValid: {
        name: this.textInputName,
        isValid: false,
        value: "",
      },
    };
  },
  computed: {
    textValue() {
      return this.parentValue;
    },
  },
  watch: {},
  mounted() {
    this.$emit("textValid", this.isTextValid);
  },
  methods: {
    checkValue() {
      console.log(this.passwordInput);
    },
    declareTextInput(data) {
      if (data?.baseValid) {
        this.isTextValid.isValid = true;
        this.isTextValid.value = this.textValue;
      }
      return this.$emit("textValid", this.isTextValid);
    },
  },
};
</script>

<style></style>
