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
          <div class="d-flex justify-content-between mb-4">
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
          <p class="m-0 fs-5 fw-bold mb-4">Product details</p>
          <div class="row" style="padding: 12px">
            <div class="col-lg-4">
              <ul class="list-group align-items-center">
                <li
                  v-for="(item, index) in tabProductDetails"
                  :key="index"
                  @click="changeTPDDirect(item.name)"
                  class="list-group-item list-group-item-action row d-flex align-items-center"
                  :class="{ 'direction-angle': directTDPangle === item.name }"
                >
                  <i class="col-lg-2 p-0 fa-solid" :class="item.icon"></i><span class="col-lg-1">{{ item.name }}</span>
                </li>
              </ul>
            </div>
            <div class="col-lg-8 border bg-white rounded">
              <div class="price-container p-3">
                <div class="d-flex gap-4">
                  <div>
                    <label for="" class="form-label fw-bold">Regular Price</label>
                    <TextInput :placeholder="'$$$'"></TextInput>
                  </div>
                  <div>
                    <label for="" class="form-label fw-bold">Sale Price</label>
                    <TextInput :placeholder="'$$$'"></TextInput>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 p-0 pe-2">
        <div class="add-card">
          <p class="m-0 fs-5 fw-bold mb-4">Fill with product</p>
          <div class="mb-4">
            <label for="p-catalog" class="form-label">Catalogue <a href="" class="">Add new catalogue</a></label>
            <div class="select-container">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                <label class="form-check-label" for="flexCheckDefault"> Default checkbox </label>
              </div>
            </div>
          </div>
          <div>
            <label for="p-catalog" class="form-label">Collection <a href="" class="">Add new collection</a></label>
            <div class="select-container">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                <label class="form-check-label" for="flexCheckDefault"> Default checkbox </label>
              </div>
            </div>
          </div>
        </div>
        <div class="add-card">
          <p class="m-0 fs-5 fw-bold mb-3">Add new catalog or collection</p>
          <CCTabComponent></CCTabComponent>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import TextInput from "../../../Components/InputField/TextInput.vue";
import FileInput from "../../../Components/InputField/FileInput.vue";
import DateInput from "../../../Components/InputField/DateInput.vue";
import CCTabComponent from "./CCTabComponent.vue";
export default {
  components: {
    TextInput,
    FileInput,
    DateInput,
    CCTabComponent,
  },
  data() {
    return {
      directTDPangle: "Pricing",
      tabProductDetails: [
        { name: "Pricing", icon: "fa-dollar-sign" },
        { name: "Restock", icon: "fa-cubes-stacked" },
        { name: "Supplier", icon: "fa-truck-field" },
        { name: "Capacities", icon: "fa-boxes-packing" },
      ],
    };
  },
  methods: {
    changeTPDDirect(value) {
      this.directTDPangle = value;
    },
  },
};
</script>
<style>
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
.list-group-item-action {
  height: 60px;
}
.list-group-item-action:hover {
  cursor: pointer;
}
.nav-item:hover {
  cursor: pointer;
}
.direction-angle {
  font-weight: bold;
}
.direction-angle > i::before {
  font-size: 18px;
}
.direction-angle::after {
  content: "";
  width: 15px;
  height: 15px;
  border-top: 0.5px solid rgb(220, 220, 220);
  border-right: 0.5px solid rgb(220, 220, 220);
  background-color: white;
  transform: rotate(45deg);
  position: absolute;
  right: -8px;
  top: 21px;
  display: block;
}
</style>
