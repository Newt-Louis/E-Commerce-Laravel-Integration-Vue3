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
      <div class="modal-content">
        <div class="modal-header" style="height: 93px">
          <h1 class="modal-title fs-3 text-primary" id="addOrEditUserLabel" v-if="isAdd">Add New User</h1>
          <h1 class="modal-title fs-3 text-warning" id="addOrEditUserLabel" v-else>Edit User</h1>
          <div style="width: 30%"></div>
          <div class="alert alert-success m-0 align-self-center" role="alert">A simple success alert—check it out!</div>
          <!-- <div class="alert alert-danger" role="alert">A simple danger alert—check it out!</div> -->
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form @submit.prevent="addOrUpdate" novalidate>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
                <label for="" class="form-label col-form-label">User name</label>
                <TextInput
                  :text-input-name="`username`"
                  :placeholder="`User Name`"
                  :required="true"
                  :pattern="'^\\S*$'"
                  @text-valid="checkValidateInputs"
                  v-model:input-value="userInfo.nameValue"
                >
                  <template #required> Please input your username ! </template>
                  <template #pattern> Username cannot contain spaces ! </template>
                </TextInput>
              </div>
              <div class="col-lg-6">
                <label for="" class="form-label col-form-label">Email</label>
                <EmailInput
                  v-model:email-edit-value="userInfo.emailValue"
                  @email-valid="checkValidateInputs"
                ></EmailInput>
              </div>
              <div class="col-lg-6">
                <label class="form-label col-form-label">Password</label>
                <PasswordInput
                  v-model:input-value="userInfo.passwordValue"
                  :required="isAdd"
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
                  @text-valid="checkValidateInputs"
                >
                  <template #pattern> Start with 0 and must have 10 characters number ! </template>
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
                <FileInput
                  v-model="userInfo.avatarValue"
                  :imageNumber="1"
                  @files-valid="getFileData"
                  :image-url-server="userData.avatar"
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
import { mapActions, mapState } from "pinia";
import { useValidateStateStore } from "../../js/piniaStores/validateStateStore";
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
  },
  emit: [],
  data() {
    return {
      registeredInputs: [],
      closeModal: false,
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
        message: "",
        alertAnime: "",
      },
    };
  },
  computed: {
    ...mapState(useValidateStateStore, ["validateState"]),
    isInputsValidated() {
      const inputs = this.isAdd
        ? [...this.registeredInputs]
        : this.registeredInputs.filter((input) => input.name !== "password" && input.name !== "confirmpassword");
      console.log(inputs);

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
          this.userInfo.avatarValue = newVal.avatar;
        }
      },
      deep: true,
    },
    "userInfo.roleValue": {
      handler(newVal) {
        const roleInput = this.registeredInputs.find((input) => input.name === "role");
        if (newVal === "") {
          roleInput.isValid = false;
        } else {
          roleInput.isValid = true;
          roleInput.value = newVal;
        }
      },
    },
  },
  mounted() {
    this.registeredInputs.push({ name: "role", isValid: false, value: "" });
  },
  methods: {
    ...mapActions(useValidateStateStore, ["turnValidateOff"]),
    checkValidateInputs(data) {
      const existingInput = this.registeredInputs.find((input) => data.name === input.name);
      if (existingInput) {
        existingInput.isValid = data.isValid;
      } else {
        this.registeredInputs.push(data);
      }
      console.log(data);
    },
    getFileData(data) {
      if (data?.value.length > 0) {
        this.userInfo.avatarValue.push(data.value[0]);
        console.log(this.userInfo.avatarValue);
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
      try {
        const response = await axsIns.post("/api/users", formData);
        if (response.status === 200) {
          this.hanldeOnCloseModal();
        }
      } catch (error) {
        console.log(error);
      }
    },
    hanldeOnCloseModal() {
      this.turnValidateOff();
      console.log(this.validateState);
      this.closeModal = true;
    },
    testValue() {
      console.log(this.userInfo);
      console.log(this.userData);
    },
  },
};
</script>

<style></style>
