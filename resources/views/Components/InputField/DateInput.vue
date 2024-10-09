<template>
  <div>
    <input
      v-model="isDateValid.value"
      type="datetime-local"
      :class="`form-control ${isValidation}`"
      @change="handleDateChange"
    />
  </div>
</template>

<script>
export default {
  emits: ["dateValid"],
  data() {
    return {
      isValidation: "",
      isDateValid: {
        name: "date",
        isValid: false,
        value: "",
      },
    };
  },
  mounted() {
    this.$emit("dateValid", this.isDateValid);
  },
  methods: {
    handleDateChange(event) {
      if (event.target.value === "") {
        this.isValidation = "";
        this.isDateValid.isValid = false;
      } else {
        this.isValidation = "is-valid";
        this.isDateValid.isValid = true;
        this.isDateValid.value = event.target.value;
        this.$emit("dateValid", this.isDateValid);
      }
    },
  },
};
</script>

<style></style>
