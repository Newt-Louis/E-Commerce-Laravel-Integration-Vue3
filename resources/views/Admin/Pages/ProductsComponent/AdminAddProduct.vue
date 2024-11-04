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
          <p class="m-0 fs-5 fw-bold mb-4">Product details</p>
          <div class="row" style="padding: 12px">
            <div class="col-lg-4">
              <ul class="list-group align-items-center">
                <li
                  v-for="(item, index) in tabProductDetails"
                  :key="index"
                  @click="changeTPDDirect(item.name)"
                  class="list-group-item list-group-item-action row d-flex align-items-center"
                  :class="{ 'direction-angle': directTDPAngle === item.name }"
                >
                  <i class="col-lg-2 p-0 fa-solid" :class="item.icon"></i><span class="col-lg-1">{{ item.name }}</span>
                </li>
              </ul>
            </div>
            <div class="col-lg-8 border bg-white rounded position-relative">
              <div class="price-container p-3 direction-angle-right" v-show="false">
                <div class="row align-items-center justify-content-center gap-2">
                  <div class="col-lg-3"></div>
                  <div class="col-lg-4">
                    <p class="fw-bold">Regular price</p>
                  </div>
                  <div class="col-lg-4">
                    <p class="fw-bold">Sale price</p>
                  </div>
                  <div class="col-lg-3">(capacity)</div>
                  <div class="col-lg-4">
                    <TextInput :placeholder="'$$$'"></TextInput>
                  </div>
                  <div class="col-lg-4">
                    <TextInput :placeholder="'$$$'"></TextInput>
                  </div>
                </div>
              </div>
              <div class="restock-container p-3 direction-angle-right" v-show="false">
                <div>
                  <p class="fw-bold m-0 mb-2 text-secondary">
                    Add to inventory <br />
                    <span class="fs-6 fw-light">Must fill with capacities on each quantity</span>
                  </p>
                  <div class="d-flex gap-2 align-items-center mb-2">
                    <p class="fw-semibold m-0">(Capacity)</p>
                    <TextInput :placeholder="'Quantity...'"></TextInput>
                  </div>
                </div>
              </div>
              <div class="supplier-container p-3 direction-angle-right" v-show="false">
                <div class="h-100 w-100 d-inline-block">
                  <p class="fw-bold text-secondary">Supplier</p>
                  <div class="d-flex gap-2 align-items-center mb-2">
                    <TextInput :placeholder="'Supplier name ...'"></TextInput>
                  </div>
                  <div class="h-50 d-flex align-items-end justify-content-end">
                    <span class="fw-light fst-italic">Supplier may be add more info later</span>
                  </div>
                </div>
              </div>
              <div class="capacities-container p-3 direction-angle-right" v-show="true">
                <p class="fw-bold text-secondary">Capacities</p>
                <div class="capacities-show mb-3">
                  <div class="row row-cols-auto">
                    <div class="col">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                        <label class="form-check-label" for="flexCheckDefault"> Default</label>
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                        <label class="form-check-label" for="flexCheckDefault"> Default</label>
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                        <label class="form-check-label" for="flexCheckDefault"> Default ldkfgjdfklgj</label>
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                        <label class="form-check-label" for="flexCheckDefault"> Default fgjfl</label>
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                        <label class="form-check-label" for="flexCheckDefault"> Defaultfgdgdfg</label>
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                        <label class="form-check-label" for="flexCheckDefault"> Default skdfjlsadkfj</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="capacities-adding">
                  <p class="fw-bold text-secondary">Or add more</p>
                  <div class="d-flex gap-2 mb-2">
                    <div class="d-flex flex-column gap-2">
                      <div class="d-flex align-items-center gap-2">
                        <label for="" class="">Name</label>
                        <TextInput :placeholder="'bottle, box, bar...'"></TextInput>
                      </div>
                      <div class="d-flex align-items-center gap-2">
                        <label for="" class="">Volume</label>
                        <TextInput :placeholder="'1kg, 1.5ml, 5cm...'"></TextInput>
                      </div>
                    </div>
                    <button class="btn btn-primary w-25">New capacity</button>
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
      directTDPAngleContentRight: "21px",
      directTDPAngle: "Pricing",
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
      this.directTDPAngle = value;
    },
  },
};
</script>
<style scoped>
:root {
  --position-input-detail: 30px;
}
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
  z-index: 9;
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
  z-index: 10;
}
.direction-angle:hover::after {
  background-color: rgb(248, 249, 251);
}
.direction-angle-right::before {
  content: "";
  width: 15px;
  height: 15px;
  display: block;
  border-top: 0.5px solid rgb(220, 220, 220);
  border-right: 0.5px solid rgb(220, 220, 220);
  transform: rotate(45deg);
  background-color: rgb(240, 240, 240);
  position: absolute;
  left: -8px;
  top: v-bind(directTDPAngleContentRight);
  z-index: 1;
}
.supplier-container {
  height: 100%;
}
</style>
