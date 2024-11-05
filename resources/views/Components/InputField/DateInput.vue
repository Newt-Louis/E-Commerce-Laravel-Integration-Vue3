<template>
  <div>
    <input
      :value="inputValue"
      type="datetime-local"
      :class="`form-control ${isValidation}`"
      @input="handleDateInput"
      @change="handleDateChange"
    />
  </div>
</template>

<script>
export default {
  props: {
    inputValue: {
      type: Date,
    },
  },
  emits: ["dateValid", "update:inputValue"],
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
    handleDateInput(event) {
      this.$emit("update:inputValue", event.target.value);
    },
  },
};
</script>

<style></style>
