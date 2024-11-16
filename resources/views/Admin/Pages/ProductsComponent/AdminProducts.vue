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
      <div class="table-responsive w-100">
        <table class="table table-hover caption-top">
          <caption>
            List of Products
          </caption>
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Images</th>
              <th scope="col">Description</th>
              <th scope="col">Gender</th>
              <th scope="col">Origin</th>
              <th scope="col">Category name</th>
              <th scope="col">Capacities</th>
              <th scope="col">Collection</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in getProductsData" :key="index">
              <td>
                <span class="fw-bold">{{ item.id }}</span>
              </td>
              <td>
                <a href="">{{ item.name }}</a>
              </td>
              <td>
                <div class="images-container" v-if="item.product_images.length > 0">
                  <img
                    class="me-2"
                    v-for="(image, index) in item.product_images"
                    :key="index"
                    :src="image.fullpath"
                    alt=""
                    width="50px"
                    height="50px"
                  />
                </div>
                <div v-else>
                  <img src="/blank_avatar.jpg" alt="" width="50px" height="50px" />
                </div>
              </td>
              <td class="text-wrap">{{ item.description }}</td>
              <td>{{ item.gender }}</td>
              <td>{{ item.origin }}</td>
              <td>{{ item.item_type.name }}</td>
              <td>
                <div v-if="item.capacities.length > 0" class="d-inline-flex p-2 flex-wrap">
                  <span
                    class="badge text-wrap text-bg-secondary capacity-badge me-2"
                    v-for="(capacity, index) in item.capacities"
                    :key="index"
                    >{{ capacity.name + " (" + capacity.volume + ")" }}</span
                  >
                </div>
                <div v-else>
                  <span>None</span>
                </div>
              </td>
              <td>
                <div v-if="item.capacities.length > 0">
                  <div v-for="(capacity, index) in item.capacities" :key="index">
                    <div v-if="capacity.pivot.collections.length > 0">
                      <span class="badge text-bg-secondary">{{ capacity.name }}</span>
                      <span class="me-2" v-for="(collect, index) in capacity.pivot.collections" :key="index">{{
                        collect.name
                      }}</span>
                    </div>
                    <div v-else>
                      <span>None</span>
                    </div>
                  </div>
                </div>
                <div v-else>
                  <span>None</span>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
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
      tableHeader: {
        oneCol: ["#", "Name", "Images", "Gender", "Origin", "Description", "Category"],
        multiCol: {
          collection: [],
          capacities: [],
        },
      },
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
.capacity-badge {
}
</style>
