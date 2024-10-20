<template>
  <div>
    <ul class="nav flex-column nav-underline bg-info-subtle p-3 rounded">
      <li class="nav-item">
        <router-link :to="{ name: 'admin-homepage' }" class="nav-link" activeClass="active">User</router-link>
      </li>
      <li class="nav-item">
        <router-link :to="{ name: 'admin-product' }" class="nav-link" activeClass="active"> Product </router-link>
      </li>
      <li class="nav-item">
        <router-link :to="{ name: 'admin-order' }" class="nav-link" activeClass="active">Client Order</router-link>
      </li>
      <li class="nav-item">
        <router-link :to="{ name: 'admin-purchase' }" class="nav-link" activeClass="active">Purchase</router-link>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"
          >Dropdown</a
        >
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#">Action</a></li>
          <li><a class="dropdown-item" href="#">Another action</a></li>
          <li><a class="dropdown-item" href="#">Something else here</a></li>
          <li><hr class="dropdown-divider" /></li>
          <li><a class="dropdown-item" href="#">Separated link</a></li>
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link">Link</a>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      activated: "active",
    };
  },
  computed: {},
  watch: {},
  methods: {
    changeActive() {},
  },
};
</script>

<style>
/* .nav-underline .nav-link.router-link-active {
  font-weight: bold;
  color: black;
} */
</style>
