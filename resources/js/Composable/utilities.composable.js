import { computed } from "vue";

export function useUtilities() {
  const isEmptyObject = (obj) => {
    return Object.keys(obj).length === 0;
  };
  const checkStringLowerCase = (string1, string2) => {
    return string1.toLowerCase().includes(string2.toLowerCase());
  };
  const numberWithCommas = (stringNumber) => {
    stringNumber = stringNumber.trim();
    return stringNumber.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  };
  return { isEmptyObject, checkStringLowerCase, numberWithCommas };
}
