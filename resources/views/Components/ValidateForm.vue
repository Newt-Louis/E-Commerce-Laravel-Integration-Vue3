<template>
  <form action="" novalidate>
    <BaseInput :required="true" :minlength="8" :placeholder="`Nhập tên tài khoản`">
      <template #required>
        <div class="invalid-feedback">Input username</div>
      </template>
      <template #minlength>
        <div class="invalid-feedback">username at least 8 character !</div>
      </template>
    </BaseInput>
    <PasswordInput
      :required="true"
      :minlength="8"
      :placeholder="'Nhập mật khẩu'"
      @password-valid="registerInputComponents"
    >
      <template #required> Input username </template>
      <template #minlength> Password at least 8 character ! </template>
    </PasswordInput>
  </form>
</template>

<script>
import PasswordInput from "./InputField/PasswordInput.vue";
import BaseInput from "~components/InputField/BaseInput.vue";

export default {
  data() {
    return {
      isValidate: false,
      detectInput: [],
    };
  },
  methods: {
    registerInputComponents(data) {
      const key = Object.keys(data);
      if (key.includes("name") && key.includes("isValid")) {
        this.detectInput.push(data);
      }
    },
  },
  mounted() {},
  components: {
    PasswordInput,
    BaseInput,
  },
};
</script>

<style></style>
