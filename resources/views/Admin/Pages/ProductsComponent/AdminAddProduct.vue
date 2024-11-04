<template>
  <div class="addproduct-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h3 class="m-0">Add a product</h3>
        <p class="fs-6 text-secondary m-0">Additionally collection and more !</p>
      </div>
      <div class="d-grid gap-2 d-lg-block">
        <button class="btn btn-outline-dark btn-sm me-2">Discard</button>
        <button class="btn btn-outline-primary btn-sm me-2">Save draft</button>
        <button class="btn btn-primary btn-sm">Publish product</button>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-8 m-0">
        <div class="d-flex flex-column add-product-info">
          <div class="mb-4">
            <label for="p-title" class="form-label fw-bold fs-5">Product Title</label>
            <TextInput
              :placeholder="`Write title here ...`"
              :text-input-name="`product-title`"
              id="p-title"
            ></TextInput>
          </div>
          <div class="mb-3">
            <label for="p-des" class="form-label fw-bold fs-5">Product Description</label>
            <textarea class="form-control" id="p-des"></textarea>
          </div>
          <div class="d-flex justify-content-around mb-4">
            <div>
              <label for="p-gender" class="form-label fw-bold fs-5">Gender</label>
              <select name="" id="p-gender" class="form-select">
                <option value="">Select Gender</option>
                <option value="lady">Lady</option>
                <option value="gentlemen">Gentlemen</option>
                <option value="unisex">Unisex</option>
              </select>
            </div>
            <div>
              <label for="p-title" class="form-label fw-bold fs-5">Product Origin</label>
              <TextInput
                :placeholder="`Write origin here ...`"
                :text-input-name="`product-origin`"
                id="p-origin"
              ></TextInput>
            </div>
          </div>
          <div>
            <FileInput :image-number="4"></FileInput>
          </div>
        </div>
        <div class="add-product-info">
          <p class="m-0 fs-5 fw-bold">Product details</p>
          <TPDComponent></TPDComponent>
        </div>
        <div class="add-product-info">
          <p class="fs-5 fw-bold">Check information before add</p>
          <div class="row row-cols-auto">
            <p class="col">Name:</p>
            <p class="col">Gender:</p>
            <p class="col">Origin:</p>
            <p class="col">Capacity:</p>
            <p class="col">Regular price:</p>
            <p class="col">Sale price:</p>
            <p class="col">Inventory:</p>
            <p class="col">Supplier:</p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 p-0 pe-2">
        <div class="add-card">
          <p class="fs-5 fw-bold">Fill with product</p>
          <div class="mb-4">
            <label for="p-catalog" class="form-label"
              >Catalogue <a href="#" class="" @click.prevent="switchCatalogTab">Add new catalogue</a></label
            >
            <div class="select-container">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                <label class="form-check-label" for="flexCheckDefault"> Default checkbox </label>
              </div>
            </div>
          </div>
          <div>
            <label for="p-catalog" class="form-label"
              >Collection <a href="#" class="" @click.prevent="switchCollectionTab">Add new collection</a></label
            >
            <div class="select-container">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                <label class="form-check-label" for="flexCheckDefault"> Default checkbox </label>
              </div>
            </div>
          </div>
        </div>
        <div class="add-card">
          <p class="m-0 fs-5 fw-bold">Information</p>
          <div class="">
            <ul class="list-group list-group-flush">
              <li class="list-group-item bg-transparent">An item</li>
              <li class="list-group-item bg-transparent">A second item</li>
              <li class="list-group-item bg-transparent">A third item</li>
              <li class="list-group-item bg-transparent">A fourth item</li>
              <li class="list-group-item bg-transparent">And a fifth one</li>
            </ul>
          </div>
        </div>
        <div class="add-card">
          <p class="m-0 fs-5 fw-bold">Add new catalog or collection</p>
          <CCTabComponent ref="navTabs"></CCTabComponent>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import TextInput from "../../../Components/InputField/TextInput.vue";
import FileInput from "../../../Components/InputField/FileInput.vue";
import DateInput from "../../../Components/InputField/DateInput.vue";
import TPDComponent from "./TPDComponent.vue";
import CCTabComponent from "./CCTabComponent.vue";
export default {
  components: {
    TextInput,
    FileInput,
    TPDComponent,
    CCTabComponent,
  },
  data() {
    return {};
  },
  watch: {},
  methods: {
    switchCatalogTab() {
      this.$refs.navTabs.handleWithCCTab("catalogue");
    },
    switchCollectionTab() {
      this.$refs.navTabs.handleWithCCTab("collection");
    },
  },
};
</script>
<style scoped>
.add-product-info {
  background-color: rgb(240, 240, 240);
  border-radius: 8px;
  margin-bottom: 12px;
  padding: 12px;
}
.add-card {
  background-color: rgb(240, 240, 240);
  border: 0.5px solid rgb(230, 230, 230);
  border-radius: 8px;
  padding: 12px;
  margin-bottom: 12px;
}
.select-container {
  height: 120px;
  overflow-y: scroll;
  background-color: white;
  border: 0.5px solid rgb(230, 230, 230);
  border-radius: 8px;
  padding: 8px;
}
</style>
