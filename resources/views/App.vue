<template>
  <div class="layout-container">
    <header><Header /></header>
    <h1>Xin chào từ component Vue!</h1>
    <main>
      <RouterView />
    </main>
    <footer></footer>
  </div>
</template>
<script>

import Header from './Layouts/Header.vue';

export default {
  components: {
    Header
  },
}
</script>
<style scoped>
/* CSS dành riêng cho component này */
</style>