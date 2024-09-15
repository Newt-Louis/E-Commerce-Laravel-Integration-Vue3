<template>
  <div class="layout-container">
    <header><HeaderComponent /></header>
    <main>
      <RouterView />
    </main>
    <footer>
      <FooterComponent />
    </footer>
  </div>
</template>

<script>
import HeaderComponent from "./Layouts/HeaderComponent.vue";
import FooterComponent from "./Layouts/FooterComponent.vue";

export default {
  components: {
    HeaderComponent,
    FooterComponent,
  },
};
</script>
<style scoped></style>
