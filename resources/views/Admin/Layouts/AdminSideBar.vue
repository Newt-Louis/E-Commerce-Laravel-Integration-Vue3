<template>
  <div>
    <ul class="nav flex-column nav-underline bg-info-subtle p-3 rounded">
      <li class="nav-item" @click="changeActive">
        <router-link :to="{ name: 'admin-homepage' }" class="nav-link" activeClass="active"> User </router-link>
      </li>
      <li class="nav-item">
        <router-link
          :to="{ path: '/admin/product' }"
          class="nav-link"
          activeClass="active"
          data-bs-toggle="collapse"
          href="#collapseAdminProduct"
          role="button"
          aria-expanded="false"
          aria-controls="collapseAdminProduct"
          @click="isProductLinkActive = !isProductLinkActive"
        >
          Product
          <i class="fa-solid fa-caret-right ms-2" v-if="!isProductLinkActive"></i>
          <i class="fa-solid fa-caret-down ms-2" v-else></i>
        </router-link>
        <div class="collapse" id="collapseAdminProduct">
          <div class="card card-body bg-info-subtle border-0">
            <li
              class="nav-item"
              v-for="(link, index) in productRouteLink"
              :key="index"
              @click="activeProductLink = index"
            >
              <router-link
                :to="{ name: link.routeLink }"
                class="nav-link"
                :activeClass="activeProductLink === index ? 'active' : ''"
              >
                <i class="fa-solid fa-angles-right" v-if="activeProductLink === index"></i> {{ link.name }}
              </router-link>
            </li>
          </div>
        </div>
      </li>
      <li class="nav-item" @click="changeActive">
        <router-link :to="{ name: 'admin-order' }" class="nav-link" activeClass="active">Client Order</router-link>
      </li>
      <li class="nav-item" @click="changeActive">
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
      activeProductLink: null,
      isProductLinkActive: false,
      productRouteLink: [
        { routeLink: "admin-product", name: "Products" },
        { routeLink: "admin-add-product", name: "Add" },
        { routeLink: "admin-edit-product-origin", name: "Edit" },
      ],
    };
  },
  computed: {},
  watch: {},
  methods: {
    changeActive() {
      this.activeProductLink = null;
    },
  },
};
</script>

<style>
/* .nav-underline .nav-link.router-link-active {
  font-weight: bold;
  color: black;
} */
</style>
