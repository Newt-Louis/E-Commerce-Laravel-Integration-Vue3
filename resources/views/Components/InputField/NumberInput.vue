<template>
  <BaseInput :type-number="true" v-bind="$attrs" @bi-valid="declareNumberInput" :pattern="'^[1-9]\\d*(,\\d+)*$'">
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
        <slot name="pattern"> Available only for number ! </slot>
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
  emits: ["numberValid"],
  data() {
    return {
      isNumberValid: {
        name: "number",
        isValid: false,
        value: "",
      },
    };
  },
  computed: {},
  watch: {},
  mounted() {
    this.$emit("numberValid", this.isNumberValid);
  },
  methods: {
    declareNumberInput(validationData) {
      if (validationData?.baseValid) {
        this.isNumberValid.isValid = true;
        this.isNumberValid.value = validationData?.numberValue;
      }
      return this.$emit("numberValid", this.isNumberValid);
    },
  },
};
</script>

<style></style>
