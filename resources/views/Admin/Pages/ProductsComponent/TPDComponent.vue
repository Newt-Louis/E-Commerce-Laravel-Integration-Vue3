<template>
  <div class="row" style="padding: 12px">
    <div class="col-lg-4">
      <ul class="list-group align-items-center">
        <li
          v-for="(item, index) in tabProductDetails"
          :key="index"
          @click="changeTPDDirect(item.name)"
          class="list-group-item list-group-item-action row d-flex align-items-center"
          :class="{ 'direction-angle': switchTab === item.name }"
        >
          <i class="col-lg-2 p-0 fa-solid" :class="item.icon"></i><span class="col-lg-1">{{ item.name }}</span>
        </li>
      </ul>
    </div>
    <div class="col-lg-8 border bg-white rounded position-relative">
      <div class="price-container p-3 direction-angle-right" v-show="switchTab === tdpContent.price.name">
        <p class="fw-bold m-0 mb-2 text-secondary">
          Add price <br />
          <span class="fs-6 fw-light">Must fill with capacities on each quantity</span>
        </p>
        <div class="row">
          <div class="col">
            <p class="fw-bold text-center">Measurement</p>
          </div>
          <div class="col text-center">
            <p class="fw-bold">Regular price</p>
          </div>
          <div class="col text-center">
            <p class="fw-bold">Sale price</p>
          </div>
        </div>
        <div
          class="row row-auto-cols justify-content-between mb-3"
          v-for="(capacity, index) in capacitiesChosenData"
          :key="index"
        >
          <div class="col fw-semibold mt-2">{{ capacity.name + " (" + capacity.volume + ")" }}</div>
          <div class="col w-25">
            <NumberInput
              v-model="capacity.price"
              :placeholder="'$$$'"
              :number-input-name="capacity.name + 'Regular'"
              @number-valid="handleOnPriceInput"
            ></NumberInput>
          </div>
          <div class="col w-25">
            <TextInput
              v-model:input-value="capacity.discount"
              :placeholder="'0.325, 0.1...'"
              :text-input-name="capacity.name + 'Sale'"
              :pattern="'^(?:0|[1-9]\\d*)(?:\\.\\d+)?$'"
              @text-valid="handleOnPriceInput"
            >
              <template #pattern>Discount must be written as a decimal number: 0.1, 0.235 etc... </template>
            </TextInput>
          </div>
        </div>
      </div>
      <div class="restock-container p-3 direction-angle-right" v-show="switchTab === tdpContent.restock.name">
        <div>
          <p class="fw-bold m-0 mb-2 text-secondary">
            Add to inventory <br />
            <span class="fs-6 fw-light">Must fill with capacities on each quantity</span>
          </p>
          <div class="row align-items-center mb-2" v-for="(capacity, index) in getCapacitiesChosenData" :key="index">
            <div class="col-lg-5">
              <p class="fw-semibold m-0">{{ capacity.name + " (" + capacity.volume + ")" }}</p>
            </div>
            <div class="col-lg-7">
              <NumberInput
                :placeholder="'Quantity...'"
                :number-input-name="capacity.name + 'Inventory'"
                v-model="capacity.inventory"
                @number-valid="hanldeOnRestockInput"
              ></NumberInput>
            </div>
          </div>
        </div>
      </div>
      <div class="supplier-container p-3 direction-angle-right" v-show="switchTab === tdpContent.supplier.name">
        <div class="h-100 w-100 d-inline-block">
          <p class="fw-bold text-secondary">Supplier</p>
          <div class="d-flex gap-2 align-items-center mb-2">
            <TextInput
              :placeholder="'Supplier name ...'"
              :text-input-name="'supplier'"
              v-model:input-value="supplierValue"
              @text-valid="handleOnSupplierInput"
            ></TextInput>
          </div>
          <div class="h-50 d-flex align-items-end justify-content-end">
            <span class="fw-light fst-italic">Supplier may be add more info later</span>
          </div>
        </div>
      </div>
      <div class="capacities-container p-3 direction-angle-right" v-show="switchTab === tdpContent.capacities.name">
        <p class="fw-bold text-secondary">Capacities</p>
        <div class="capacities-show mb-3">
          <div class="row row-cols-auto">
            <div class="col" v-for="(capacity, index) in capacitiesIndexData" :key="index">
              <div class="form-check">
                <input
                  class="form-check-input"
                  type="checkbox"
                  :value="capacity.name"
                  :id="index"
                  @input="handleOnCapacityCheckbox($event, index)"
                />
                <label class="form-check-label" for="flexCheckDefault">{{
                  capacity.name + " (" + capacity.volume + ")"
                }}</label>
              </div>
            </div>
          </div>
        </div>
        <div class="capacities-adding">
          <p class="fw-bold text-secondary">Or add more</p>
          <div class="d-flex gap-2 mb-2">
            <div class="d-flex flex-column gap-2">
              <div class="d-flex gap-2 justify-content-between">
                <label for="" class="">Name: </label>
                <TextInput
                  :placeholder="'bottle, box, bar...'"
                  v-model:input-value="capacitiesAddingIns.name"
                  :text-input-name="'capacityName'"
                  :required="true"
                  @text-valid="checkCapacitiesInput"
                >
                  <template #required>Must have a name like jar, bottle...</template>
                </TextInput>
              </div>
              <div class="d-flex gap-2 justify-content-between">
                <label for="" class="">Volume: </label>
                <TextInput
                  :placeholder="'1g, 1.5ml, 5cm...'"
                  v-model:input-value="capacitiesAddingIns.volume"
                  :text-input-name="'capacityVolume'"
                  :required="true"
                  @text-valid="checkCapacitiesInput"
                >
                  <template #required>Must have a measurement unit like ml, g, cm...</template>
                </TextInput>
              </div>
            </div>
            <button
              class="btn btn-primary w-25"
              style="height: 84px"
              @click="addNewCapacity"
              :disabled="!isRegisteredCapacitiesInputDone"
            >
              New capacity
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { axsIns } from "../../../../js/bootstrap";
import TextInput from "../../../Components/InputField/TextInput.vue";
import NumberInput from "../../../Components/InputField/NumberInput.vue";
export default {
  components: {
    TextInput,
    NumberInput,
  },
  props: {
    isResetField: {
      type: Boolean,
    },
  },
  emits: ["update:pdInfo"],
  data() {
    return {
      tdpContent: {
        price: { name: "Pricing", directAngle: "21px" },
        restock: { name: "Restock", directAngle: "80px" },
        supplier: { name: "Supplier", directAngle: "140px" },
        capacities: { name: "Capacities", directAngle: "200px" },
      },
      directAngleContentRight: "21px",
      switchTab: "Pricing",
      tabProductDetails: [
        { name: "Pricing", icon: "fa-dollar-sign" },
        { name: "Restock", icon: "fa-cubes-stacked" },
        { name: "Supplier", icon: "fa-truck-field" },
        { name: "Capacities", icon: "fa-boxes-packing" },
      ],
      capacitiesIndexData: [],
      capacitiesChosenData: [],
      capacitiesAddingIns: {
        name: "",
        volume: "",
      },
      registeredCapacitiesInput: [],
      pdInfo: [],
      supplierValue: "",
    };
  },
  computed: {
    isRegisteredCapacitiesInputDone() {
      return this.registeredCapacitiesInput.every((capacity) => capacity.isValid === true);
    },
    getCapacitiesChosenData() {
      return this.capacitiesChosenData;
    },
  },
  watch: {
    isResetField: {
      handler(newVal) {
        if (newVal === true) {
          this.capacitiesChosenData = [];
        }
      },
    },
  },
  async mounted() {
    try {
      const capacitiesResponse = await axsIns.get("/api/capacities");
      if (capacitiesResponse.status === 200) {
        this.capacitiesIndexData = capacitiesResponse.data;
      }
    } catch (error) {
      console.log(error);
    }
  },
  methods: {
    changeTPDDirect(value) {
      this.switchTab = value;
      Object.values(this.tdpContent).forEach((element) => {
        if (value === element.name) {
          this.directAngleContentRight = element.directAngle;
        }
      });
    },
    async addNewCapacity() {
      try {
        const addCapacityResponse = await axsIns.post("/api/capacities", this.capacitiesAddingIns);
        if (addCapacityResponse.status === 200) {
          this.capacitiesIndexData = addCapacityResponse.data;
          this.capacitiesAddingIns.name = "";
          this.capacitiesAddingIns.volume = "";
        }
      } catch (error) {
        console.log(error);
      }
    },
    checkCapacitiesInput(data) {
      const existInput = this.registeredCapacitiesInput.find((registered) => registered.name === data.name);
      if (existInput) {
        existInput.isValid = data.isValid;
      } else {
        this.registeredCapacitiesInput.push(data);
      }
    },
    handleOnCapacityCheckbox(event, index) {
      const value = event.target.value;
      if (event.target.checked) {
        const capacityInstance = {
          ...this.capacitiesIndexData[index],
          price: "",
          discount: "",
          inventory: "",
          supplier: "",
        };
        this.capacitiesChosenData.push(capacityInstance);
      } else {
        const capacityIns = this.capacitiesIndexData[index];
        const capacityChosenIndex = this.capacitiesChosenData.findIndex(
          (capacity) => capacity.name === capacityIns.name
        );
        this.capacitiesChosenData.splice(capacityChosenIndex, 1);
      }
      this.handleOnProductDetailsInfo();
    },
    handleOnPriceInput(data) {
      this.handleOnProductDetailsInfo();
    },
    hanldeOnRestockInput(data) {
      this.handleOnProductDetailsInfo();
    },
    handleOnSupplierInput(data) {
      if (this.capacitiesChosenData.length > 0) {
        for (let index = 0; index < this.capacitiesChosenData.length; index++) {
          this.capacitiesChosenData[index].supplier = this.supplierValue;
        }
      }
      this.handleOnProductDetailsInfo();
    },
    handleOnProductDetailsInfo() {
      this.$emit("update:pdInfo", this.capacitiesChosenData, !(this.capacitiesChosenData.length > 0));
    },
  },
};
</script>
<style>
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
  top: v-bind(directAngleContentRight);
  z-index: 1;
}
.supplier-container {
  height: 100%;
}
</style>
