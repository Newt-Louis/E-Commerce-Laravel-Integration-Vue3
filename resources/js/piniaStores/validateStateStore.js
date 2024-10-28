import { defineStore } from "pinia";

export const useValidateStateStore = defineStore("validateState", {
  state: () => {
    return {
      stopValid: false,
    };
  },
  getters: {
    validateState: (state) => {
      return state.stopValid;
    },
  },
  actions: {
    turnValidateOn() {
      this.stopValid = false;
    },
    turnValidateOff() {
      this.stopValid = true;
    },
  },
});
