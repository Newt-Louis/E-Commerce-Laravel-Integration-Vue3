import { ref } from "vue";

const required = (value) => {
  if (value === "") {
    return {
      status: false,
    };
  } else {
    return {
      status: true,
    };
  }
};

const minlength = (value, stringLength) => {
  if (value === "") {
    return {
      status: false,
    };
  }
  if (value.length < stringLength) {
    return {
      status: false,
    };
  } else {
    return {
      status: true,
    };
  }
};

const maxlength = (value, stringLength) => {
  if (value === "") {
    return {
      status: false,
    };
  }
  if (value.length > stringLength) {
    return {
      status: false,
    };
  }
};

const pattern = (value, stringPattern) => {
  if (value === "") {
    return {
      state: false,
    };
  }
  const regexp = new RegExp(stringPattern);
  const matchesPattern = regexp.test(value);
  if (matchesPattern) {
    return {
      state: true,
    };
  } else {
    return {
      state: false,
    };
  }
};

const email = (value) => {
  const emailPattern = "/^[a-z0-9._-]+@[a-z0-9.-]+.[a-z]{2,}$/i;";
  const regexp = new RegExp(emailPattern);
  const checkEmail = regexp.test(value);
  if (checkEmail) {
    return {
      status: true,
    };
  }
  return { status: false };
};
export function useInputRules(value, rules) {}
