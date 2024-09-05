<template>
  <div class="layout-container">
    <header><Header /></header>
    <main>
      <RouterView/>
    </main>
    <footer>
      <Footer/>
    </footer>
  </div>
</template>

<script>
import Header from './Layouts/Header.vue';
import SideBar from './Layouts/SideBar.vue';
import Footer from './Layouts/Footer.vue';

export default {
  components: {
    Header,
    Footer,
    SideBar,
  },
}
</script>
<style scoped>
/* CSS dành riêng cho component này */
</style>