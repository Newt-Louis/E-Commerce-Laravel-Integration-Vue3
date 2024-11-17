<template>
  <div class="products-container">
    <div class="products-header p-4 mb-4">
      <h3>Products</h3>
      <div class="d-inline-flex mb-3">
        <div class="me-3">
          <a href="" class="link-primary link-underline-opacity-0 link-underline-opacity-100-hover">All </a> (product
          number)
        </div>
        <div class="me-3">
          <a href="" class="link-primary link-underline-opacity-0 link-underline-opacity-100-hover">Published </a>
          (product number)
        </div>
        <div class="me-3">
          <a href="" class="link-primary link-underline-opacity-0 link-underline-opacity-100-hover">On Discount </a>
          (product number)
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3">
          <TextInput :placeholder="`Search product`"></TextInput>
        </div>
        <div class="col-lg-6 btn-group">
          <select name="" id="" class="form-select">
            <option value="">Origin</option>
            <option value="2">2</option>
            <option value="3">3</option>
          </select>
          <select name="" id="" class="form-select">
            <option value="">Capacity</option>
            <option value="2">2</option>
            <option value="3">3</option>
          </select>
          <select name="" id="" class="form-select">
            <option value="">Category</option>
            <option value="2">2</option>
            <option value="3">3</option>
          </select>
        </div>
        <div class="col-lg-3">
          <button type="button" class="btn btn-primary me-2">+ Add Filter</button>
          <button type="button" class="btn btn-outline-success"><i class="fa-solid fa-file-export"></i> Export</button>
        </div>
        <div class="col-lg-3"></div>
        <div class="col-lg-3"></div>
      </div>
    </div>
    <div class="products-main mb-4">
      <p class="fs-5 text-secondary">List of products</p>
      <div class="product-lists">
        <div class="lists-container">
          <ul class="list-group list-group-flush">
            <li
              class="list-group-item list-group-item-action d-flex flex-column"
              v-for="(item, index) in getProductsData"
              :key="index"
              data-bs-toggle="collapse"
              :data-bs-target="`#${item.id + '_' + index}`"
              aria-expanded="false"
              :aria-controls="item.id + '_' + index"
            >
              <div class="row row-cols-auto w-100 row-gap-2">
                <div class="col">
                  <span class="fw-bold">ID: {{ item.id }}</span>
                </div>
                <div class="col">
                  Name: <a href="">{{ item.name }}</a>
                </div>
                <div class="col d-flex me-2">
                  <img
                    width="50px"
                    height="50px"
                    v-for="image in item.product_images"
                    :key="image.id"
                    :src="image.fullpath"
                    :alt="image.product_id"
                  />
                </div>
                <div class="col">Description: {{ item.description }}</div>
                <div class="col">Gender: {{ item.gender }}</div>
                <div class="col">Origin: {{ item.origin }}</div>
                <div class="col">Category name: {{ item.item_type.name }}</div>
              </div>
              <div class="collapse" :id="item.id + '_' + index" v-if="item.capacities.length > 0">
                <hr />
                <div class="row row-cols-auto w-100" v-for="(capacity, index) in item.capacities" :key="index">
                  <div class="col">
                    <span
                      >Capacity:
                      <span class="badge text-bg-primary">{{
                        capacity.name + " (" + capacity.volume + ")"
                      }}</span></span
                    >
                  </div>
                  <div class="col" v-if="capacity.pivot.collections.length > 0">
                    <span
                      >Collection:
                      <span
                        class="badge text-bg-secondary me-2"
                        v-for="(collect, index) in capacity.pivot.collections"
                        :key="index"
                        >{{ collect.name }}</span
                      ></span
                    >
                  </div>
                  <div class="col" v-else>
                    <span>Collection: None</span>
                  </div>
                  <div class="col">
                    <span v-if="capacity.pivot.inventory !== null"
                      >Inventory: <span class="badge text-bg-success">{{ capacity.pivot.inventory }}</span>
                    </span>
                    <span v-else>Inventory: None</span>
                  </div>
                  <div class="col">
                    <span v-if="capacity.pivot.supplier !== null">Supplier: {{ capacity.pivot.supplier }}</span>
                    <span v-else>Supplier: None</span>
                  </div>
                  <div class="col">
                    <span v-if="capacity.pivot.price !== null">Price: {{ capacity.pivot.price }}</span>
                    <span v-else>Price: None</span>
                  </div>
                  <div class="col">
                    <span v-if="capacity.pivot.discount !== null">Discount: {{ capacity.pivot.discount }}</span>
                    <span v-else>Discount: None</span>
                  </div>
                </div>
              </div>
              <div class="collapse" :id="item.id + '_' + index" v-else>
                <hr />
                <span class="fw-bold fs-5">None</span>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="pagination-container float-end">
      <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-end">
          <li class="page-item" v-for="(link, index) in getProductPaginates" :key="index">
            <a
              class="page-link"
              :class="{ active: link.active, disabled: link.url === null }"
              @click="handleOnPaginate(link.url)"
              >{{ formattedLabel(link.label) }}</a
            >
          </li>
        </ul>
      </nav>
    </div>
  </div>
</template>
<script>
import { axsIns } from "../../../../js/bootstrap";
import TextInput from "../../../Components/InputField/TextInput.vue";
export default {
  components: {
    TextInput,
  },
  props: {},
  emits: [],
  data() {
    return {
      dataIndexProducts: [],
      dataPaginateProducts: [],
      notification: {
        isDone: false,
        isError: false,
        message: "",
        alertAnimate: "",
      },
    };
  },
  computed: {
    getProductsData() {
      return this.dataIndexProducts;
    },
    getProductPaginates() {
      return this.dataPaginateProducts;
    },
    formattedLabel() {
      return (label) => {
        return label.replace("&laquo;", "").replace("&raquo;", "");
      };
    },
  },
  watch: {},
  async mounted() {
    try {
      const productResponse = await axsIns.get("/api/products");
      if (productResponse.status === 200) {
        this.dataIndexProducts = productResponse.data.data;
        this.dataPaginateProducts = productResponse.data.meta.links;
        console.log(productResponse);
      }
    } catch (error) {
      console.log(error);
    }
  },
  methods: {
    async handleOnPaginate(url) {
      if (!url) {
        return;
      }
      try {
        const pageResponse = await axsIns.get(url);
        if (pageResponse.status === 200) {
          this.dataIndexProducts = pageResponse.data.data;
          this.dataPaginateProducts = pageResponse.data.meta.links;
        }
      } catch (error) {
        console.log(error);
        this.notify("Something Wrong", "isError");
      }
    },
    notify(message, warningType) {
      this.notification[warningType] = true;
      this.notification.message = message;
      this.notification.alertAnimate = "animate__fadeIn";
      setTimeout(() => {
        this.notification[warningType] = false;
        this.notification.message = "";
        this.notification.alertAnimate = "";
      }, 5000);
    },
  },
};
</script>
<style>
.products-header {
  background-color: rgb(240, 240, 240);
}
.scroll-table {
  overflow-x: scroll;
}
.table {
  width: 200%;
}
tbody > tr > td {
  width: 250px;
  word-break: break-all;
}
tbody > tr > td:first-child {
  width: 50px;
}
.product-lists {
  width: 100%;
  overflow-x: scroll;
}
.lists-container {
  width: 200%;
}
.list-group-item:hover {
  cursor: pointer;
}
.capacity-badge {
}
</style>
