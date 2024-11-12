<template>
  <div class="addproduct-container">
    <!-- <div class="alert alert-danger" role="alert">A simple danger alert—check it out!</div> -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h3 class="m-0">Add a product</h3>
        <p class="fs-6 text-secondary m-0">Additionally collection and more !</p>
      </div>
      <div class="d-grid gap-2 d-lg-block">
        <button class="btn btn-outline-dark btn-sm me-2">Discard</button>
        <button class="btn btn-outline-primary btn-sm me-2">Save draft</button>
        <button class="btn btn-primary btn-sm" @click="handleOnAddProduct">Publish product</button>
      </div>
    </div>
    <!-------------------------- Input filed basic info Product ---------------------->
    <div class="row">
      <div class="col-lg-8 m-0">
        <div class="d-flex flex-column add-product-info">
          <div class="mb-4">
            <label for="p-title" class="form-label fw-bold fs-5">Product Title</label>
            <TextInput
              v-model:input-value="productBasicInfo.title"
              :placeholder="`Write title here ...`"
              :text-input-name="`product-title`"
              id="p-title"
            ></TextInput>
          </div>
          <div class="mb-3">
            <label for="p-des" class="form-label fw-bold fs-5">Product Description</label>
            <textarea class="form-control" id="p-des" v-model="productBasicInfo.description"></textarea>
          </div>
          <div class="d-flex justify-content-around mb-4">
            <div>
              <label for="p-gender" class="form-label fw-bold fs-5">Gender</label>
              <select name="" id="p-gender" class="form-select" v-model="productBasicInfo.gender">
                <option value="">Select Gender</option>
                <option value="lady">Lady</option>
                <option value="gentlemen">Gentlemen</option>
                <option value="unisex">Unisex</option>
              </select>
            </div>
            <div>
              <label for="p-title" class="form-label fw-bold fs-5">Product Origin</label>
              <TextInput
                v-model:input-value="productBasicInfo.origin"
                :placeholder="`Write origin here ...`"
                :text-input-name="`product-origin`"
                id="p-origin"
              >
              </TextInput>
            </div>
          </div>
          <div>
            <FileInput :image-number="4" @files-valid="getFileData"></FileInput>
          </div>
        </div>
        <div class="add-product-info">
          <p class="m-0 fs-5 fw-bold">Product details</p>
          <TPDComponent
            :is-reset-field="validateState.resetField"
            @update:pd-info="handleOnUpdatePDInfo"
          ></TPDComponent>
        </div>
        <div class="add-product-info">
          <p class="fs-5 fw-bold">Result adding</p>
          <ol class="list-group list-group-numbered list-group-flush" v-if="pdInfo.length > 0">
            <li class="list-group-item d-flex bg-transparent" v-for="(item, index) in pdInfo" :key="index">
              <div>
                <div><span class="fw-bold">Product name:</span> {{ productBasicInfo.title }}</div>
                <div class="row row-cols-auto">
                  <p class="col m-0">Regular price: {{ item.price }}</p>
                  <p class="col m-0">Sale price: {{ item.discount }}</p>
                  <p class="col m-0">Gender: {{ productBasicInfo.gender }}</p>
                  <p class="col m-0">Origin: {{ productBasicInfo.origin }}</p>
                  <p class="col m-0">Supplier: {{ item.supplier }}</p>
                  <p class="col m-0">Capacity: {{ item.name + " (" + item.volume + ")" }}</p>
                  <p class="col m-0">Inventory: {{ item.inventory }}</p>
                  <p class="col m-0" v-if="item?.collection && item.collection.length > 0">
                    Collection:
                    <span v-for="(collect, index) in item.collection" :key="index">{{ collect.name + ", " }}</span>
                  </p>
                </div>
              </div>
            </li>
          </ol>
        </div>
      </div>
      <div class="col-lg-4 p-0 pe-2">
        <!------------------------ Add Categories & Collection ---------------------->
        <div class="add-card">
          <p class="fs-5 fw-bold">Fill with product</p>
          <div class="mb-4">
            <label for="p-catalog" class="form-label"
              >Catalogue <a href="#" class="" @click.prevent="switchCatalogTab">Add new catalogue</a></label
            >
            <div class="select-container">
              <div class="form-check" v-for="(category, index) in getCatalogueData" :key="index">
                <input
                  class="form-check-input"
                  type="radio"
                  name="catalog"
                  :value="category.id"
                  :id="category.name"
                  @input="catalogueChosen"
                />
                <label class="form-check-label" :for="category.name"> {{ category.name }} </label>
              </div>
            </div>
          </div>
          <div>
            <label for="p-catalog" class="form-label"
              >Collection <a href="#" class="" @click.prevent="switchCollectionTab">Add new collection</a></label
            >
            <div class="select-container">
              <div class="form-check" v-for="(collect, index) in getCollectionData" :key="index">
                <input
                  class="form-check-input"
                  type="checkbox"
                  :value="collect.id"
                  :id="collect.name"
                  @input="collectionChosen"
                />
                <label class="form-check-label" :for="collect.name"> {{ collect.name }} </label>
              </div>
            </div>
          </div>
        </div>
        <div class="add-card" v-if="collectionChosenData.length > 0">
          <p class="fs-5 fw-bold">Choose product with</p>
          <div class="mb-3" v-for="(collect, index) in collectionChosenData" :key="index">
            <p class="m-0 fw-semibold">{{ collect?.name }}</p>
            <div class="select-container" v-if="pdInfo.length > 0">
              <div class="form-check" v-for="(item, index) in pdInfo" :key="index">
                <input
                  class="form-check-input"
                  type="checkbox"
                  :value="item.name"
                  :id="index"
                  @input="getCollectionForProduct($event, collect.id)"
                />
                <label class="form-check-label" :for="index"> {{ "product name" + " (" + item.name + ")" }} </label>
              </div>
            </div>
          </div>
        </div>
        <div class="add-card">
          <p class="m-0 fs-5 fw-bold">Collection information</p>
          <div class="">
            <ul class="list-group list-group-flush">
              <li class="list-group-item bg-transparent" v-for="(collect, index) in getCollectionData" :key="index">
                <span
                  class="delete-collect-button position-absolute translate-middle p-2 bg-danger border border-light rounded-circle"
                  @click="deleteChooseCollect(collect.id)"
                >
                </span>

                <p class="m-0"><span class="fst-italic">Collection name: </span> {{ collect.name }}</p>
                <div class="d-flex align-items-center">
                  <span class="fst-italic">Start: </span>
                  <span class="ms-2 text-center">{{ collect.start_at ? collect.start_at : "None" }}</span>
                  <span class="ms-3 fst-italic">End: </span>
                  <span class="ms-2 text-center">{{ collect.end_at ? collect.end_at : "None" }}</span>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <div class="add-card">
          <p class="fs-5 fw-bold">Add new catalog or collection</p>
          <CCTabComponent
            ref="navTabs"
            @updateCatalogIndex="catalogueChangeData"
            @update-collection-index="collectionChangeData"
          ></CCTabComponent>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import TextInput from "../../../Components/InputField/TextInput.vue";
import FileInput from "../../../Components/InputField/FileInput.vue";
import NumberInput from "../../../Components/InputField/NumberInput.vue";
import TPDComponent from "./TPDComponent.vue";
import CCTabComponent from "./CCTabComponent.vue";
import { axsIns } from "../../../../js/bootstrap";
export default {
  components: {
    TextInput,
    FileInput,
    NumberInput,
    TPDComponent,
    CCTabComponent,
  },
  data() {
    return {
      notification: {
        isError: false,
        isDone: false,
        message: "",
        alertAnime: "",
      },
      validateState: {
        title: true,
        catalogue: true,
        resetField: false,
      },
      productBasicInfo: {
        title: "",
        description: "",
        gender: "",
        origin: "",
        itemTypeId: "",
        pImages: [],
      },
      catalogueIndexData: [],
      // catalogueChosenData: [],
      collectionIndexData: [],
      collectionChosenData: [],
      pdInfo: [],
    };
  },
  computed: {
    getCatalogueData() {
      const arrayToSort = [...this.catalogueIndexData];
      return arrayToSort.sort((a, b) => b.id - a.id);
    },
    getCollectionData() {
      const arrayToSort = [...this.collectionIndexData];
      return arrayToSort.sort((a, b) => b.id - a.id);
    },
  },
  watch: {},
  async mounted() {
    try {
      const [catalogueResponse, collectionResponse] = await Promise.all([
        axsIns.get("/api/categories"),
        axsIns.get("/api/collections"),
      ]);
      if (catalogueResponse.status === 200) {
        this.catalogueIndexData = catalogueResponse.data;
      }
      if (collectionResponse.status === 200) {
        this.collectionIndexData = collectionResponse.data;
      }
    } catch (error) {
      console.log(error);
    }
  },
  methods: {
    switchCatalogTab() {
      this.$refs.navTabs.handleWithCCTab("catalogue");
    },
    switchCollectionTab() {
      this.$refs.navTabs.handleWithCCTab("collection");
    },
    catalogueChangeData(data) {
      this.catalogueIndexData = data;
    },
    collectionChangeData(data) {
      this.collectionIndexData = data;
    },
    catalogueChosen(event) {
      this.productBasicInfo.itemTypeId = event.target.value;
      // if (event.target.checked) {
      //   if (!this.catalogueChosenData.includes(value)) {
      //     this.catalogueChosenData.push(value);
      //   }
      // } else {
      //   const index = this.catalogueChosenData.findIndex((catalogueValue) => catalogueValue === value);
      //   this.catalogueChosenData.splice(index, 1);
      // }
    },
    collectionChosen(event) {
      const idCollect = event.target.value;
      if (event.target.checked) {
        const collectionInstance = this.collectionIndexData.find((collect) => collect.id === +idCollect);
        this.collectionChosenData.push(collectionInstance);
      } else {
        const index = this.collectionChosenData.findIndex((collect) => collect.id === +idCollect);
        this.collectionChosenData.splice(index, 1);
      }
    },
    async deleteChooseCollect(id) {
      try {
        const response = await axsIns.delete("/api/collections/" + id);
        console.log(response);
        if (response.status === 200) {
          this.collectionChangeData(response.data);
        }
      } catch (error) {
        console.log(error);
      }
    },
    getFileData(data) {
      if (data?.value.length > 0) {
        data.value.forEach((element) => {
          this.productBasicInfo.pImages.push(element);
        });
      }
    },
    getCollectionForProduct(event, collectionID) {
      const capacityName = event.target.value;
      const PDInstance = this.pdInfo.find((prod) => prod.name === capacityName);
      if (event.target.checked) {
        if (!PDInstance?.collection) {
          PDInstance["collection"] = [];
        }
        PDInstance["collection"].push(this.collectionChosenData.find((collect) => collect.id === collectionID));
      } else {
        const index = PDInstance["collection"].findIndex((collect) => collect.id === collectionID);
        PDInstance["collection"].splice(index, 1);
      }
      /*
        property may not include in product detail instance cause collection don't have to
        had a collection property so we have to take care about this collection property when
        send a request to add a product
      */
      console.log(this.pdInfo);
    },
    handleOnUpdatePDInfo(data, isResetFiled) {
      this.pdInfo = data;
      this.validateState.resetField = isResetFiled;
    },
    async handleOnAddProduct() {
      const formData = new FormData();
      if (this.productBasicInfo.title === "" || this.productBasicInfo.itemTypeId === "") {
        this.notify("Products must have a title and a category", "isError");
        return;
      } else {
        formData.append("name", this.productBasicInfo.title);
        formData.append("description", this.productBasicInfo.description);
        formData.append("gender", this.productBasicInfo.gender);
        formData.append("origin", this.productBasicInfo.origin);
        formData.append("item_type_id", this.productBasicInfo.itemTypeId);
        if (this.productBasicInfo.pImages.length > 0) {
          this.productBasicInfo.pImages.forEach((image, index) => {
            formData.append(`product_images[${index}]`, image);
          });
        }
      }
      if (this.pdInfo.length > 0) {
        this.pdInfo.forEach((pdInstance, index) => {
          formData.append(`product_details[${index}]`, pdInstance);
        });
      }
      this.clearField();
      // console.log(this.productBasicInfo);
      // console.log(this.pdInfo);
      // try {
      //   const response = await axsIns.post("/api/products", formData);
      //   if (response.status === 200) {
      //     this.notify("Add new product success");
      //     this.clearField();
      //   }
      // } catch (error) {
      //   console.log(error);
      // }
    },
    notify(message, warningType) {
      this.notification[warningType] = true;
      this.notification.message = message;
      this.notification.alertAnime = "animate__fadeIn";
      setTimeout(() => {
        this.notification[warningType] = false;
        this.notification.message = "";
        this.notification.alertAnime = "";
      }, 5000);
    },
    clearField() {
      this.productBasicInfo.title = "";
      this.productBasicInfo.description = "";
      this.productBasicInfo.gender = "";
      this.productBasicInfo.itemTypeId = "";
      this.productBasicInfo.origin = "";
      this.productBasicInfo.pImages = [];
      this.pdInfo = [];
      this.validateState.resetField = true;
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
.delete-collect-button {
  display: none;
  top: 15px;
  right: 0;
}
.delete-collect-button:hover {
  cursor: pointer;
  top: 14px;
  right: 1px;
}
.delete-collect-button:active {
  transform: translate(0, 0);
  top: 15px;
  right: 0;
}
.list-group-item:hover {
  border-radius: 8px;
  background-color: rgba(255, 255, 255, 0.7) !important;
}
.list-group-item:hover .delete-collect-button {
  display: block;
  animation: enabledDeleteCollectButton 0.4s ease-in;
}
@keyframes enabledDeleteCollectButton {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}
</style>
