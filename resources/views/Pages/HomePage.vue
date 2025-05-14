<template>
  <div class="container">
    <h1>Trang Chủ Client</h1>
    <button @click="getEvent">let's go</button>
    <form novalidate class="mt-5">
       <input class="form-control mb-2" type="text" name="" id="" v-model="validInput"/>
      <button class="btn btn-primary" @click="inputHandle" type="button">
        Test
      </button>
    </form>
  </div>
</template>

<script>
import {axsIns} from "@/bootstrap.js";

export default {
  components: {},
  data() {
    return {
      validInput: "",
      fileValues: [],
    };
  },
  computed: {},
  watch: {},
  methods: {
    getEvent() {
      console.log(this.validInput);
    },
    async inputHandle (data) {
      let inputValue = this.validInput;
      try{
        const response = await axsIns.post('/api/test-language-detection',{inputValue});
        console.log(response);
      }catch (e) {
        console.log(e);
      }
    },
  },
};
</script>

<style></style>
