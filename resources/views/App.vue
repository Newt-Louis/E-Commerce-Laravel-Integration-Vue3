<template>
  <div class="layout-container">
    <header><Header /></header>
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