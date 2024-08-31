<template>
  <div class="header-container">
    <div>
      <router-link to="/">HomePage</router-link>
      <router-link to="/about">About</router-link>
      <!-- <h1>HomePage Link</h1> -->
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      msg: 'hello from header component !',
    }
  },
}
</script>

<style>

</style>