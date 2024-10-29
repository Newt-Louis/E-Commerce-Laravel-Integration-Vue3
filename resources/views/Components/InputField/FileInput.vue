<template>
  <div class="inputfile-layout">
    <input
      type="file"
      ref="fileTextValue"
      @change="onFileChange"
      :class="`form-control ${isValidation}`"
      multiple
      id="file-input"
    />
    <div class="invalid-feedback">
      <span>{{ errMess }}</span>
    </div>
    <!--     <div v-if="imageUrl.length > 0 && imageUrlServer.length === 0" class="img-container">
      <div v-for="(img, index) in imageUrl" :key="index" class="img-element">
        <img :src="img" alt="" width="70px" height="70px" style="border-radius: 8px" />
      </div>
    </div>
    <div v-else class="img-container">
      <div v-for="(img, index) in imageUrlServer" :key="index" class="img-element">
        <img :src="img" alt="" width="70px" height="70px" style="border-radius: 8px" />
      </div>
    </div>
  </div> -->
    <div class="img-container">
      <div v-for="(img, index) in imageUrl" :key="index" class="img-element">
        <img :src="img" alt="" width="70px" height="70px" style="border-radius: 8px" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    imageNumber: {
      type: Number,
      default: 0,
    },
    imageUrlServer: {
      type: Array,
      default: () => [],
    },
    validateState: {
      type: Boolean,
      default: true,
    },
  },
  emits: ["filesValid"],
  data() {
    return {
      imageUrl: [],
      fileTextValue: "",
      isValidation: "",
      errMess: "",
      isFileValid: {
        name: "file",
        isValid: false,
        value: [],
      },
    };
  },
  computed: {},
  watch: {
    imageUrlServer: {
      handler(newVal) {
        if (newVal) {
          this.imageUrl = newVal;
        }
      },
    },
    validateState: {
      handler(newVal) {
        if (newVal === false) {
          this.isValidation = "";
          this.imageUrl = [];
          this.$refs.fileTextValue.value = "";
        }
      },
    },
  },
  mounted() {
    this.$emit("filesValid", this.isFileValid);
  },
  methods: {
    onFileChange(event) {
      const files = event.target.files;
      this.imageUrl = [];

      if (files.length > this.imageNumber) {
        this.isValidation = "is-invalid";
        this.errMess = `Only ${this.imageNumber} images can be uploaded !`;
        return;
      } else if (files.length === 0) {
        this.isValidation = "";
        this.errMess = "";
        return;
      } else {
        let isFilesValid = false;
        for (let i = 0; i < files.length; i++) {
          const file = files[i];
          const isValidType = file.type.startsWith("image/");
          const isValidSize = file.size <= 1024 * 1024;

          if (!isValidType || !isValidSize) {
            this.isValidation = "is-invalid";
            this.errMess = "File must be image type and max size 1MB";
            isFilesValid = false;
            return;
          }

          this.isValidation = "is-valid";
          this.errMess = "";
          const reader = new FileReader();
          reader.onload = (e) => {
            this.imageUrl.push(e.target.result);
          };
          reader.readAsDataURL(file);
          this.isFileValid.value.push(file);
          isFilesValid = true;
        }
        if (isFilesValid) {
          this.isFileValid.isValid = true;
          this.$emit("filesValid", this.isFileValid);
        }
      }
    },
  },
};
</script>

<style>
.img-container {
  display: flex;
  justify-content: space-evenly;
  margin-top: 16px;
}
.img-element {
  border: 0.5px solid rgba(170, 170, 170, 0.5);
  border-radius: 8px;
  box-shadow: 2px 2px 5px rgb(210, 210, 210);
}
</style>
