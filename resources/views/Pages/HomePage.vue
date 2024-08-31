<template>
  <div>
    <h1>Trang Chủ Client</h1>
    <button @click="gotoAbout">let's go</button>
  </div>
</template>

<script>
export default {
  methods: {
    gotoAbout() {
      this.$router.push('/about')
    }
  },
}
</script>

<style>

</style>