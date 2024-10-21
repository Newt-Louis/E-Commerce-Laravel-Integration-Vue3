<template>
  <div class="login-page">
    <div :class="`alert alert-danger animate__animated ${isLogin.alertAnimate}`" role="alert" v-if="isLogin.isAlert">
      {{ isLogin.messageError }}
    </div>
    <form class="login-form d-none d-lg-block" @submit.prevent="signIn" novalidate>
      <h1 class="text-primary text-center mb-4">Admin Sign In</h1>
      <div class="row">
        <div class="col-lg-3 mb-3">
          <label for="inputUserName" class="form-label col-form-label">User Name</label>
        </div>
        <div class="col-lg-9 mb-3">
          <TextInput
            v-model="loginValue.usernameValue"
            :placeholder="`Username`"
            :required="true"
            @text-valid="checkValidateInputs"
          >
            <template #required> Please input your username ! </template>
          </TextInput>
        </div>
        <div class="col-lg-3 mb-3">
          <label for="inputPassword" class="form-label col-form-label" :required="true">Password</label>
        </div>
        <div class="col-lg-9 mb-3">
          <PasswordInput
            v-model="loginValue.passwordValue"
            :placeholder="`Password`"
            :required="true"
            @password-valid="checkValidateInputs"
          >
            <template #required> Please input your password ! </template>
          </PasswordInput>
        </div>
        <div class="col-lg-3 mb-3">
          <label for="inputPasswordConfirm" class="form-label col-form-label">Password Confirm</label>
        </div>
        <div class="col-lg-9 mb-3">
          <PasswordConfirmInput
            v-model="loginValue.confirmPasswordValue"
            :placeholder="`Confirm Password`"
            :password="loginValue.passwordValue"
            @confirm-password-valid="checkValidateInputs"
          >
            Confirm Password & Password do not match !
          </PasswordConfirmInput>
        </div>
        <div class="col-lg-3 mb-3"></div>
        <div class="col-lg-9 mb-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="gridCheck1" v-model="loginValue.rememberMe" />
            <label class="form-check-label" for="gridCheck1"> Remember Me For 30 Days ! </label>
          </div>
        </div>
        <div class="col-lg-3 mb-3"></div>
        <div class="col-lg-9 mb-3">
          <div class="row">
            <p class="col-lg-4 col-sm-12">Forgot password !</p>
          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-primary w-100" :disabled="!isInputsValidated">Sign in</button>
    </form>
    <form @submit.prevent="signIn" class="login-form-sm d-lg-none d-sm-block" novalidate>
      <div class="row">
        <div class="col-12 mb-3">
          <label for="inputUserNameMobile" class="form-label col-form-label">User Name</label>
        </div>
        <div class="col-sm-12 mb-3">
          <TextInput
            v-model="loginValue.usernameValue"
            :placeholder="`Username`"
            :required="true"
            @text-valid="checkValidateInputs"
          >
            <template #required> Please input your username ! </template>
          </TextInput>
        </div>
        <div class="col-sm-12 mb-3">
          <label for="inputPasswordMobile" class="form-label col-form-label">Password</label>
        </div>
        <div class="col-sm-12 mb-3">
          <PasswordInput
            v-model="loginValue.passwordValue"
            :placeholder="`Password`"
            :required="true"
            @password-valid="checkValidateInputs"
          >
            <template #required> Please input your password ! </template>
          </PasswordInput>
        </div>
        <div class="col-lg-3 mb-3">
          <label for="inputPasswordConfirmMobile" class="form-label col-form-label">Password Confirm</label>
        </div>
        <div class="col-sm-12 mb-3">
          <PasswordConfirmInput
            v-model="loginValue.confirmPasswordValue"
            :placeholder="`Confirm Password`"
            :password="loginValue.passwordValue"
            @confirm-password-valid="checkValidateInputs"
          >
            Confirm Password & Password do not match !
          </PasswordConfirmInput>
        </div>
        <div class="col-sm-12 mb-3"></div>
        <div class="col-sm-12 mb-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="gridCheck" v-model="loginValue.rememberMe" />
            <label class="form-check-label" for="gridCheck"> Remember Me For 30 Days ! </label>
          </div>
        </div>
        <div class="col-sm-12 mb-3"></div>
        <div class="col-sm-12 mb-3">
          <div class="d-flex flex-column">
            <span class="mb-3">Forgot password !</span>
          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-primary w-100" :disabled="!isInputsValidated">Sign in</button>
    </form>
  </div>
</template>

<script>
import TextInput from "~components/InputField/TextInput.vue";
import PasswordInput from "~components/InputField/PasswordInput.vue";
import PasswordConfirmInput from "~components/InputField/PasswordConfirmInput.vue";
import { useAdminUserStore } from "~js/Admin/piniaStores/userAdminStore.js";
import { mapState, mapActions } from "pinia";
import { axsIns } from "../../../js/bootstrap";
export default {
  components: {
    TextInput,
    PasswordInput,
    PasswordConfirmInput,
  },
  data() {
    return {
      isSubmitDone: true,
      registeredInputs: [],
      loginValue: {
        usernameValue: "",
        passwordValue: "",
        confirmPasswordValue: "",
        rememberMe: false,
      },
      isLogin: {
        messageError: "",
        isAlert: false,
        alertAnimate: "",
      },
    };
  },
  computed: {
    ...mapState(useAdminUserStore, ["checkLogin", "getAdminUser"]),
    isInputsValidated() {
      return this.registeredInputs.every((value) => value.isValid === true);
    },
  },
  watch: {},
  mounted() {},
  methods: {
    ...mapActions(useAdminUserStore, ["setAdminUser", "setLogin"]),
    checkValidateInputs(data) {
      const existingInput = this.registeredInputs.find((value) => data.name === value.name);
      if (existingInput) {
        existingInput.isValid = data.isValid;
      } else {
        this.registeredInputs.push(data);
      }
    },
    async signIn() {
      this.isLogin.isAlert = false;
      this.isLogin.messageError = "";
      this.isLogin.alertAnimate = "";
      let response;
      try {
        response = await axsIns.post("/api/admin-user/login", this.loginValue);
      } catch (error) {
        this.isLogin.isAlert = true;
        this.isLogin.messageError = error.response.data.message;
        this.isLogin.alertAnimate = "animate__fadeInRight";
      }
      if (response.status === 200) {
        this.setLogin();
        this.setAdminUser(response.data.adminUser);
        await this.$router.push({ name: "admin-homepage" });
      }
      return;
    },
  },
};
</script>

<style>
.login-page {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  width: 100vw;
  background-color: rgb(170, 170, 170);
}
.login-form {
  width: 50%;
  padding: 24px;
  border-radius: 8px;
  background-color: white;
}
.login-form-sm {
  width: 100%;
  height: 100%;
  padding: 24px;
  background-color: white;
}
p {
  margin-bottom: 0;
}
.alert {
  position: absolute;
  top: 10px;
  right: 10px;
}
@media (max-width: 1281px) {
  .login-form {
    width: 70%;
  }
}
</style>
