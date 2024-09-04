<template>
<router-view name="login"></router-view>
<div class="row">
  <div class="col-lg-2 col-md-2">Sidebar</div>
  <div class="col-lg-10 col-md-10">
    <header>Header</header>
    <main>
      <router-view></router-view>
    </main>
    <footer>
    Footer
  </footer>
  </div>
</div>
</template>

<script>

</script>

<style scoped>

</style>