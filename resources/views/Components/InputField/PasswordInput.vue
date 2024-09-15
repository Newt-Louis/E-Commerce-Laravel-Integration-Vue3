<template>
  <BaseInput type="password" v-model="passwordValue" v-bind="$attrs">
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
    <template #email>
      <div class="invalid-feedback">
        <slot name="email"></slot>
      </div>
    </template>
  </BaseInput>
</template>

<script>
import BaseInput from "./BaseInput.vue";
export default {
  /* props: {
    
  }, */
  data() {
    return {
      passwordValue: "",
    };
  },

  methods: {
    checkValueFromPasswordInput() {
      console.log(this.passwordValue);
    },
  },
  mounted() {},
  watch: {
    passwordValue(newVal) {
      if (newVal) {
        this.checkValueFromPasswordInput();
      }
    },
  },
  components: {
    BaseInput,
  },
};
</script>

<style></style>
