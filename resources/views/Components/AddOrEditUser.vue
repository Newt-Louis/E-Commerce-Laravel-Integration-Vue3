<template>
  <div
    class="modal fade"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="addOrEditUserLabel"
    aria-hidden="true"
    id="addOrEditUser"
  >
    <div class="modal-dialog modal-lg" id="addOrEditUser">
      <div
        :class="`alert alert-success animate__animated ${notification.alertAnime}`"
        role="alert"
        v-if="notification.isDone"
      >
        {{ notification.message }}
      </div>
      <div
        :class="`alert alert-danger animate__animated ${notification.alertAnime}`"
        role="alert"
        v-if="notification.isError"
      >
        {{ notification.message }}
      </div>
      <div class="modal-content">
        <div class="modal-header" style="height: 93px">
          <h1 class="modal-title fs-3 text-primary" id="addOrEditUserLabel" v-if="isAdd">Add New User</h1>
          <h1 class="modal-title fs-3 text-warning" id="addOrEditUserLabel" v-else>Edit User</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form @submit.prevent="addOrUpdate" novalidate>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
                <label for="" class="form-label col-form-label">User Name</label>
                <TextInput
                  v-model:input-value="userInfo.nameValue"
                  :text-input-name="`username`"
                  :placeholder="`User Name`"
                  :required="true"
                  :pattern="'^\\S*$'"
                  :validate-state="validateState.name"
                  @text-valid="checkValidateInputs"
                >
                  <template #required> Please input your username ! </template>
                  <template #pattern> Username cannot contain spaces ! </template>
                </TextInput>
              </div>
              <div class="col-lg-6">
                <label for="" class="form-label col-form-label">Email</label>
                <EmailInput
                  v-model:email-edit-value="userInfo.emailValue"
                  :validate-state="validateState.email"
                  @email-valid="checkValidateInputs"
                ></EmailInput>
              </div>
              <div class="col-lg-6">
                <label class="form-label col-form-label">Password</label>
                <PasswordInput
                  v-model:input-value="userInfo.passwordValue"
                  :validate-state="validateState.password"
                  :required="true"
                  @password-valid="checkValidateInputs"
                >
                  <template #required> Please input your username ! </template>
                </PasswordInput>
              </div>
              <div class="col-lg-6">
                <label for="" class="form-label col-form-label">Confirm Password</label>
                <PasswordConfirmInput
                  v-model:confirm-password="userInfo.confirmPasswordValue"
                  @confirm-password-valid="checkValidateInputs"
                  :password="userInfo.passwordValue"
                >
                  Confirm Password & Password do not match !
                </PasswordConfirmInput>
              </div>
              <div class="col-lg-6">
                <label for="" class="form-label col-form-label">Phone</label>
                <TextInput
                  :text-input-name="`phone`"
                  v-model:input-value="userInfo.phoneValue"
                  :required="true"
                  :pattern="'^0\\d{9}$'"
                  :placeholder="`Phone Number`"
                  :validate-state="validateState.phone"
                  @text-valid="checkValidateInputs"
                >
                  <template #pattern> Start with 0 and must have 10 characters number ! </template>
                </TextInput>
              </div>
              <div class="col-lg-6">
                <label for="" class="form-label col-form-label">Role</label>
                <select
                  v-model="userInfo.roleValue"
                  :class="`form-select ${roleValidation}`"
                  @focus="roleInputFocused = true"
                  @blur="roleInputFocused = false"
                >
                  <option value="">Select user role</option>
                  <option value="1">Owner</option>
                  <option value="2">Administrator</option>
                  <option value="3">Staff</option>
                  <option value="4">Client</option>
                </select>
                <div class="invalid-feedback">
                  <span>Must have Role !</span>
                </div>
              </div>
              <div class="col-lg-6 offset-3">
                <label for="" class="form-label col-form-label">Choose Avatar</label>
                <FileInput
                  :imageNumber="1"
                  @files-valid="getFileData"
                  :image-url-server="userData.avatar"
                  :validate-state="validateState.avatar"
                ></FileInput>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" @click="testValue">Test</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="hanldeOnCloseModal">
              Close
            </button>
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
      default: () => ({ idUser: 0, name: "", email: "", phone: "", role: "", avatar: [] }),
    },
    isValidateStateOn: {
      type: Boolean,
      default: true,
    },
  },
  emits: ["closeModal", "updateUsersData"],
  data() {
    return {
      registeredInputs: [],
      roleInputFocused: false,
      roleValidation: "",
      userInfo: {
        idValue: 0,
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
        isDone: false,
        message: "",
        alertAnime: "",
      },
      validateState: {
        name: true,
        email: true,
        password: true,
        phone: true,
        avatar: true,
      },
    };
  },
  computed: {
    isInputsValidated() {
      const inputs = this.isAdd
        ? [...this.registeredInputs]
        : this.registeredInputs.filter((input) => input.name !== "password" && input.name !== "confirmpassword");
      return inputs.every((input) => input.isValid === true);
    },
  },
  watch: {
    userData: {
      handler(newVal) {
        if (newVal) {
          this.userInfo.idValue = newVal.idUser;
          this.userInfo.nameValue = newVal.name;
          this.userInfo.emailValue = newVal.email;
          this.userInfo.phoneValue = newVal.phone;
          this.userInfo.roleValue = newVal.role;
        }
      },
      deep: true,
    },
    "userInfo.roleValue": {
      handler(newVal) {
        const roleInput = this.registeredInputs.find((input) => input.name === "role");
        if (newVal === "") {
          roleInput.isValid = false;
          this.roleValidation = "is-invalid";
        } else {
          roleInput.isValid = true;
          roleInput.value = newVal;
          this.roleValidation = "is-valid";
        }
      },
    },
    isValidateStateOn: {
      handler(newVal) {
        if (newVal) {
          for (const key of Object.keys(this.validateState)) {
            this.validateState[key] = true;
          }
        } else {
          for (const key of Object.keys(this.validateState)) {
            this.validateState[key] = false;
          }
        }
      },
    },
  },
  mounted() {
    this.registeredInputs.push({ name: "role", isValid: false, value: "" });
  },
  methods: {
    checkValidateInputs(data) {
      const existingInput = this.registeredInputs.find((input) => data.name === input.name);
      if (existingInput) {
        existingInput.isValid = data.isValid;
      } else {
        this.registeredInputs.push(data);
      }
    },
    getFileData(data) {
      if (data?.value.length > 0) {
        this.userInfo.avatarValue.push(data.value[0]);
      }
    },
    async addOrUpdate() {
      const formData = new FormData();
      if (this.userInfo.idValue > 0) {
        formData.append("id", this.userInfo.idValue);
      }
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
      if (this.isAdd) {
        try {
          const response = await axsIns.post("/api/users", formData);
          if (response.status === 200) {
            this.hanldeOnCloseModal();
            this.updateUserList(response.data);
            this.notify("New user added successfully !", "isDone");
          }
        } catch (error) {
          console.log(error);
          this.notify(error.response.data.errors, "isError");
        }
      } else {
        /* 
        form data does not have method put so that laravel cannot understand method put when
        receive a request with method put, we have to use post and in FormData must append
        a field _method with value PUT.
        */
        formData.append("_method", "PUT");
        try {
          const response = await axsIns.post("/api/users/" + this.userInfo.idValue, formData);
          if (response.status === 200) {
            this.updateUserList(response.data);
            this.notify("Completed updating user information", "isDone");
          }
        } catch (error) {
          console.log(error);
          this.notify(error.response.data.errors, "isError");
        }
      }
    },
    hanldeOnCloseModal() {
      this.resetField();
      this.$emit("closeModal", { validateState: false });
    },
    testValue() {
      console.log(this.userInfo);
    },
    updateUserList(data) {
      this.$emit("updateUsersData", data);
    },
    notify(message, warningType) {
      this.notification[warningType] = true;
      this.notification.message = message;
      this.notification.alertAnime = "animate__fadeIn";
      setTimeout(() => {
        this.notification[warningType] = false;
        this.notification.message = "";
        this.notification.alertAnime = "";
      }, 5000);
    },
    resetField() {
      this.userInfo.idValue = 0;
      this.userInfo.nameValue = "";
      this.userInfo.emailValue = "";
      this.userInfo.passwordValue = "";
      this.userInfo.confirmPasswordValue = "";
      this.userInfo.phoneValue = "";
      this.userInfo.roleValue = "";
      this.userInfo.avatarValue = [];
    },
  },
};
</script>

<style></style>
