import { ref } from "vue";

const required = (value) => {
  if (value === "") {
    return {
      status: false,
      message: "Please enter information for this field",
    };
  } else {
    return {
      status: true,
      message: "Ok !",
    };
  }
};
const minlength = (value, stringLength) => {
  if (value === "") {
    return {
      status: false,
    };
  } else if (value.length < stringLength) {
    return {
      status: false,
      messgae: `Please input more than ${stringLength} character`,
    };
  } else {
    return {
      status: true,
      message: "Ok !",
    };
  }
};

const maxlength = (value, stringLength) => {
  if (value === "") {
    return {
      status: false,
    };
  } else if (value.length > stringLength) {
    return {
      status: false,
      message: `Maxium length is ${stringLength}`,
    };
  }
};
