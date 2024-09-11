export function useUtilities() {
  const isEmptyObject = (obj) => {
    return Object.keys(obj).length === 0;
  };
  const checkStringLowerCase = (string1, string2) => {
    return string1.toLowerCase().includes(string2.toLowerCase());
  };
  return { isEmptyObject, checkStringLowerCase };
}
