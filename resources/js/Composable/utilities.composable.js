export function useUtilities() {
  const isEmptyObject = (obj) => {
    return Object.keys(obj).length === 0;
  };
  const checkStringLowerCase = (string1, string2) => {
    return string1.toLowerCase().includes(string2.toLowerCase());
  };
  const numberWithCommas = (stringNumber) => {
    return stringNumber.replace(/\d(?=(\d{3})+$)/g, "$&,");
  };
  return { isEmptyObject, checkStringLowerCase, numberWithCommas };
}
