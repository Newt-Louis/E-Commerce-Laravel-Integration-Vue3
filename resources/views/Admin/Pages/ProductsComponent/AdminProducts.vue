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
      <div class="row row-gap-2">
        <div class="col-lg-3">
          <label for="searchProduct" class="form-label">Search Product</label>
          <TextInput
            :placeholder="`Filter by id, name, description`"
            :id-value="`searchProduct`"
            v-model:input-value="searchOnProduct"
          ></TextInput>
        </div>
        <div class="col-lg-2">
          <label for="collectionSelect" class="form-label">Collection</label>
          <select
            id="collectionSelect"
            class="form-select"
            v-if="dataIndexCollection.length > 0"
            v-model="filteredInstance.collection"
          >
            <option value="">All</option>
            <option v-for="(collect, index) in dataIndexCollection" :key="index" :value="collect.id">
              {{ collect.name }}
            </option>
          </select>
        </div>
        <div class="col-lg-2">
          <label for="capacitySelect" class="form-label">Capacity</label>
          <select
            id="capacitySelect"
            class="form-select"
            v-if="dataIndexCapacities.length > 0"
            v-model="filteredInstance.capacity"
          >
            <option value="">All</option>
            <option v-for="(capacity, index) in dataIndexCapacities" :key="index" :value="capacity.id">
              {{ capacity.name + " (" + capacity.volume + ")" }}
            </option>
          </select>
        </div>
        <div class="col-lg-2">
          <label for="categorySelect" class="form-label">Category</label>
          <select
            id="categorySelect"
            class="form-select"
            v-if="dataIndexCategories.length > 0"
            v-model="filteredInstance.category"
          >
            <option value="">All</option>
            <option v-for="(category, index) in dataIndexCategories" :key="index" :value="category.id">
              {{ category.name }}
            </option>
          </select>
        </div>

        <div class="col-lg-3 d-flex align-items-center">
          <div class="dropdown me-2">
            <button
              type="button"
              class="btn btn-primary dropdown-toggle"
              data-bs-toggle="dropdown"
              aria-expanded="false"
              data-bs-auto-close="outside"
            >
              +Add Filter
            </button>
            <div class="dropdown-menu px-2 py-1">
              <div class="form-check" v-for="(checkIns, index) in filterCheckbox" :key="index">
                <input
                  type="checkbox"
                  class="form-check-input"
                  :value="checkIns.name"
                  :id="checkIns.name"
                  v-model="filterSelectRender"
                />
                <label :for="checkIns.name" class="form-check-label"> {{ checkIns.name }}</label>
              </div>
            </div>
          </div>
          <div>
            <button type="button" class="btn btn-outline-success" @click="testValue()">
              <i class="fa-solid fa-file-export"></i> Export
            </button>
          </div>
        </div>
        <div class="col-lg-3" v-for="(box, index) in getFilterCheckboxInstance" :key="index">
          <label :for="box.name + '_' + index" class="form-label">{{ box.name }}</label>
          <select
            :id="box.name + '_' + index"
            class="form-select"
            aria-label="Default select example"
            v-model="filteredInstance[box.name.toLowerCase()]"
          >
            <option value="" selected>All</option>
            <option v-for="(value, index) in box.data" :key="index" :value="value">
              {{ value ? value : "None" }}
            </option>
          </select>
        </div>
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
      searchOnProduct: "",
      filterCheckbox: [
        { name: "Gender", data: [] },
        { name: "Origin", data: [] },
        { name: "Supplier", data: [] },
        { name: "Inventory", data: [] },
        { name: "Price", data: [] },
        { name: "Discount", data: [] },
      ],
      filterSelectRender: [],
      dataIndexProducts: [],
      dataPaginateProducts: [],
      dataIndexCollection: [],
      dataIndexCapacities: [],
      dataIndexCategories: [],
      filteredInstance: {
        collection: "",
        capacity: "",
        category: "",
        gender: "",
        origin: "",
        supplier: "",
        inventory: "",
        price: "",
        discount: "",
      },
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
      if (this.searchOnProduct === "") {
        return this.dataIndexProducts;
      }
      return this.dataIndexProducts.filter((item) => {
        return (
          item.name.includes(this.searchOnProduct) ||
          item.id.toString().includes(this.searchOnProduct) ||
          item.description.includes(this.searchOnProduct)
        );
      });
    },
    getProductPaginates() {
      return this.dataPaginateProducts;
    },
    getFilterCheckboxInstance() {
      const newArray = [];
      if (this.filterSelectRender.length > 0) {
        this.filterCheckbox.forEach((item) => {
          this.filterSelectRender.some((value) => {
            if (value === item.name && item.data.length > 0) {
              newArray.push(item);
              return true;
            }
          });
        });
        return newArray;
      } else {
        return [];
      }
    },
    formattedLabel() {
      return (label) => {
        return label.replace("&laquo;", "").replace("&raquo;", "");
      };
    },
  },
  watch: {
    async filterSelectRender(newVal) {
      const totalFilter = newVal.length;
      let countFilter = 0;
      for (let i = 0; i < this.filterCheckbox.length; i++) {
        const temptFilterInstance = this.filterCheckbox[i];
        newVal.forEach(async (value) => {
          const apiString = value.toLowerCase();
          if (value === "Gender" && temptFilterInstance.name === value) {
            temptFilterInstance.data = ["lady", "gentlement", "unisex"];
            countFilter += 1;
          }
          if (value !== "Gender" && temptFilterInstance.name === value) {
            if (temptFilterInstance.data.length === 0) {
              try {
                const response = await axsIns.get("/api/products/" + apiString);
                if (response.status === 200) {
                  temptFilterInstance.data = response.data;
                  countFilter += 1;
                }
              } catch (error) {
                console.log(error);
              }
            }
          }
        });
        if (countFilter === totalFilter) {
          break;
        }
      }
    },
    filteredInstance: {
      async handler(newVal) {
        if (newVal) {
          try {
            const productResponse = await axsIns.post("/api/products/filter", newVal);
            if (productResponse.status === 200) {
              this.dataIndexProducts = productResponse.data.data;
              this.dataPaginateProducts = productResponse.data.meta.links;
            }
          } catch (error) {
            console.log(error);
          }
        }
      },
      deep: true,
    },
  },
  async mounted() {
    try {
      const [productResponse, collectionResponse, capacitiesResponse, categoryResponse] = await Promise.all([
        axsIns.get("/api/products"),
        axsIns.get("/api/collections"),
        axsIns.get("/api/capacities"),
        axsIns.get("/api/categories"),
      ]);
      if (productResponse.status === 200) {
        this.dataIndexProducts = productResponse.data.data;
        this.dataPaginateProducts = productResponse.data.meta.links;
      }
      if (collectionResponse.status === 200) {
        this.dataIndexCollection = collectionResponse.data;
      }
      if (capacitiesResponse.status === 200) {
        this.dataIndexCapacities = capacitiesResponse.data;
      }
      if (categoryResponse.status === 200) {
        this.dataIndexCategories = categoryResponse.data;
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
    testValue() {
      // console.log(this.filteredInstance);
      console.log(this.filterCheckbox);
    },
  },
};
</script>
<style>
.products-header {
  border-radius: 8px;
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
