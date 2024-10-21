const validationRulesStrategies = {
  required: (value) => {
    if (value === "") {
      return false;
    }
    return true;
  },
  minlength: (value, stringLength) => {
    if (value === "" || value.length < stringLength) {
      return false;
    }
    return true;
  },
  maxlength: (value, stringLength) => {
    if (value === "" || value.length >= stringLength) {
      return false;
    }
    return true;
  },
  pattern: (value, stringPattern) => {
    if (value === "") {
      return false;
    }
    const regexp = new RegExp(stringPattern);
    return regexp.test(value);
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

    const emailPattern = /^[a-z0-9._-]+@[a-z0-9]+(\.[a-z]{2,})+$/i;
    return emailPattern.test(value);
  },
};

export function getValidator(rule, params) {
  const validator = validationRulesStrategies[rule];
  if (!validator) {
    throw new Error(`Invalid validation rule ${rule}`);
  }
  return validator(params.value, ...(params.additionalArgs || []));
}
