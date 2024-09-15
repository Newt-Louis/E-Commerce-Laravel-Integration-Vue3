import { ref } from "vue";

const validationRulesStrategies = {
  required: (value) => {
    let status = false;
    if (value === "") {
      return status;
    }
    return (status = true);
  },
  minlength: (value, stringLength) => {
    let status = false;
    if (value === "") {
      return status;
    }

    if (value.length < stringLength) {
      return status;
    }
    return (status = true);
  },
  maxlength: (value, stringLength) => {
    let status = false;
    if (value === "") {
      return status;
    }
    if (value.length >= stringLength) {
      return status;
    }
    return (status = true);
  },
  pattern: (value, stringPattern) => {
    let status = false;
    if (value === "") {
      return status;
    }
    const regexp = new RegExp(stringPattern);
    const matchesPattern = regexp.test(value);
    if (!matchesPattern) {
      return status;
    }
    return (status = true);
  },
  email: (value) => {
    // Đây là dạng tạo đối tượng Regular Expression động (dynamic)
    /*
      |  const emailPattern = "^[a-z0-9._-]+@[a-z0-9.]+\\.[a-z]{2,}$";
      |  const regexp = new RegExp(emailPattern, "i");
      |  const checkEmail = regexp.test(value); 
    */

    /* Đây là dạng tạo đối tượng Regular Expression cố định
      do chúng ta sẽ đặt validate email mặc định
      nên sẽ viết theo cách này */

    const emailPattern = /^[a-z0-9._-]+@[a-z0-9.]+.[a-z]{2,}$/i;
    const checkEmail = emailPattern.test(value);
    let status = false;
    if (checkEmail) {
      return (status = true);
    }
    return status;
  },
};

export function getValidator(rule, params) {
  const validator = validationRulesStrategies[rule];
  if (!validator) {
    throw new Error(`Invalid validation rule ${rule}`);
  }
  return validator(params.value, ...(params.additionalArgs || []));
}
