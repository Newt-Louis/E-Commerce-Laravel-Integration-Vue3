<template>
  <div
    class="modal fade"
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
                <TextInput
                  :text-input-name="`username`"
                  v-model="userInfo.nameValue"
                  :placeholder="`Username`"
                  :required="true"
                  :pattern="'^\\S*$'"
                  @text-valid="checkValidateInputs"
                >
                  <template #required> Please input your username ! </template>
                  <template #pattern> Username cannot contain spaces ! </template>
                </TextInput>
              </div>
              <div class="col-lg-6">
                <label for="" class="form-label col-form-label">Email</label>
                <EmailInput
                  v-bind="$attrs"
                  v-model="userInfo.emailValue"
                  @email-valid="checkValidateInputs"
                ></EmailInput>
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
                <TextInput
                  :text-input-name="`phone`"
                  v-model="userInfo.phoneValue"
                  :pattern="'^0\\d{9}$'"
                  :placeholder="`Phone Number`"
                  @text-valid="checkValidateInputs"
                >
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
                <FileInput v-model="userInfo.avatarValue" :imageNumber="1" @files-valid="getFileData"></FileInput>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" @click="testValue">Test</button>
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
    getFileData(data) {
      if (data?.value.length > 0) {
        this.userInfo.avatarValue.push(data.value[0]);
        console.log(this.userInfo.avatarValue);
      }
    },
    async addOrUpdate() {
      const formData = new FormData();
      formData.append("name", this.userInfo.nameValue);
      formData.append("email", this.userInfo.emailValue);
      formData.append("password", this.userInfo.passwordValue);
      formData.append("phone", this.userInfo.phoneValue);
      formData.append("role_id", this.userInfo.roleValue);
      /*
        if single file we just use normal append like this : ('avatar', this.userInfo.avatarValue[0])
        if we need to send an array of files we have to push each file to avatar array like this:
          this.selectedFiles.forEach(value => {
            formData.append("avatar[]",value); //value is each file in selectedFiles array
          });
        1. name like this : "avatar[]" to make server understand that this input filed is an array
        2. this array won't accept an array assign to it, so that we have to make an iterator
           to append each file to this array.
        3. 
      */
      formData.append("avatar[]", this.userInfo.avatarValue[0]);
      try {
        const response = await axsIns.post("/api/users", formData);
        if (response.status === 200) {
          console.log(response);
        }
      } catch (error) {
        console.log(error);
      }
    },
    testValue() {
      console.log(this.userInfo);
      console.log(this.registeredInputs);
    },
  },
};
</script>

<style></style>
