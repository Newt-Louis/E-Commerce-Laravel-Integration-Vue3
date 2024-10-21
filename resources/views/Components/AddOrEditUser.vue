<template>
  <div
    class="modal bg-dark"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    id="exampleModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-3 text-primary" id="exampleModalLabel" v-if="isAdd">Add New User</h1>
          <h1 class="modal-title fs-3 text-warning" id="exampleModalLabel" v-else>Edit User</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form @submit.prevent="addOrUpdate" novalidate>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
                <label for="" class="form-label col-form-label">User name</label>
                <TextInput :placeholder="`Username`" :required="true" @text-valid="checkValidateInputs">
                  <template #required> Please input your username ! </template>
                </TextInput>
              </div>
              <div class="col-lg-6">
                <label for="" class="form-label col-form-label">Email</label>
                <EmailInput @email-valid="checkValidateInputs"></EmailInput>
              </div>
              <div class="col-lg-6">
                <label class="form-label col-form-label">Password</label>
                <PasswordInput
                  v-model="userInfo.passwordValue"
                  :placeholder="`Password`"
                  :required="true"
                  @password-valid="checkValidateInputs"
                >
                  <template #required> Please input your username ! </template>
                </PasswordInput>
              </div>
              <div class="col-lg-6">
                <label for="" class="form-label col-form-label">Confirm Password</label>
                <PasswordConfirmInput
                  v-model="userInfo.confirmPasswordValue"
                  @confirm-password-valid="checkValidateInputs"
                  :password="userInfo.passwordValue"
                  :placeholder="`Confirm Password`"
                >
                  Confirm Password & Password do not match !
                </PasswordConfirmInput>
              </div>
              <div class="col-lg-6">
                <label for="" class="form-label col-form-label">Phone</label>
                <TextInput :pattern="'^0\\d{9}$'" :placeholder="`Phone Number`">
                  <template #pattern> Bắt đầu bằng số 0 và phải đủ 10 chữ số ! </template>
                </TextInput>
              </div>
              <div class="col-lg-6">
                <label for="" class="form-label col-form-label">Role</label>
                <select v-model="userInfo.roleValue" class="form-select">
                  <option value="">Select user role</option>
                  <option value="1">Owner</option>
                  <option value="2">Administrator</option>
                  <option value="3">Staff</option>
                  <option value="4">Client</option>
                </select>
              </div>
              <div class="col-lg-6 offset-3">
                <label for="" class="form-label col-form-label">Choose Avatar</label>
                <FileInput v-model="userInfo.avatarValue" :imageNumber="1"></FileInput>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-outline-primary" v-if="isAdd" :disabled="!isInputsValidated">
              Ok !
            </button>
            <button type="submit" class="btn btn-outline-warning" v-else :disabled="!isInputsValidated">
              Update !
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import TextInput from "./InputField/TextInput.vue";
import PasswordConfirmInput from "./InputField/PasswordConfirmInput.vue";
import PasswordInput from "./InputField/PasswordInput.vue";
import FileInput from "./InputField/FileInput.vue";
import EmailInput from "./InputField/EmailInput.vue";
import { axsIns } from "../../js/bootstrap";
export default {
  components: {
    TextInput,
    EmailInput,
    PasswordConfirmInput,
    PasswordInput,
    FileInput,
  },
  props: {
    isAdd: {
      type: Boolean,
      default: true,
    },
    userData: {
      type: Object,
      default: () => ({ name: "", email: "", password: "", phone: "", role: 0 }),
    },
  },
  emit: [],
  data() {
    return {
      registeredInputs: [],
      userInfo: {
        nameValue: "",
        emailValue: "",
        passwordValue: "",
        confirmPasswordValue: "",
        phoneValue: "",
        roleValue: "",
        avatarValue: [],
      },
      notification: {
        isError: false,
        message: "",
        alertAnime: "",
      },
    };
  },
  computed: {
    isInputsValidated() {
      return this.registeredInputs.every((value) => value.isValid === true);
    },
  },
  watch: {},
  mounted() {},
  methods: {
    checkValidateInputs(data) {
      const existingInput = this.registeredInputs.find((value) => data.name === value.name);
      if (existingInput) {
        existingInput.isValid = data.isValid;
      } else {
        this.registeredInputs.push(data);
      }
    },
    addOrUpdate() {},
  },
};
</script>

<style>
.modal {
  display: block !important;
}
</style>
