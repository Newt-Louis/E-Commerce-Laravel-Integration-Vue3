<template>
  <div>
    <div
      class="alert alert-danger animate__animated"
      :class="notification.alertAnimate"
      role="alert"
      v-if="notification.isError"
    >
      {{ notification.message }}
    </div>
    <div
      class="alert alert-success animate__animated"
      :class="notification.alertAnimate"
      role="alert"
      v-if="notification.isDone"
    >
      {{ notification.message }}
    </div>
    <div class="tab-catalog-collection bg-white rounded p-3">
      <ul class="nav nav-tabs mb-3">
        <li class="nav-item" @click="handleWithCCTab('catalogue')" ref="tabCatalog">
          <a :class="{ active: tabCatalogCollection.whichTab === 'catalogue' }" class="nav-link">Catalogue</a>
        </li>
        <li class="nav-item" @click="handleWithCCTab('collection')" ref="tabCollection">
          <a :class="{ active: tabCatalogCollection.whichTab === 'collection' }" class="nav-link">Collection</a>
        </li>
      </ul>
      <div
        class="tab-catalog-container animate__animated"
        :class="{ animate__fadeIn: tabCatalogCollection.whichTab === 'catalogue' }"
        v-if="tabCatalogCollection.whichTab === 'catalogue'"
      >
        <label for="" class="form-label">Add new catalog</label>
        <TextInput
          v-model:input-value="nameCategory"
          :placeholder="`Write catalog name ...`"
          :text-input-name="'add-catalog'"
        ></TextInput>
        <button @click="addNewCatalog" class="btn btn-primary mt-3 w-100">Ok !</button>
      </div>
      <div
        class="tab-collection-container animate__animated"
        :class="{ animate__fadeIn: tabCatalogCollection.whichTab === 'collection' }"
        v-if="tabCatalogCollection.whichTab === 'collection'"
      >
        <label for="" class="form-label">Add new collection</label>
        <TextInput
          v-model:input-value="collectionAddingInstance.nameValue"
          :placeholder="`Write collection name ...`"
          :text-input-name="'add-catalog'"
        ></TextInput>
        <label for="start_date" class="form-label">Start date</label>
        <DateInput v-model:input-value="collectionAddingInstance.startDate" id="start_date"></DateInput>
        <label for="end_date" class="form-label">End date</label>
        <DateInput v-model:input-value="collectionAddingInstance.endDate" id="end_date"></DateInput>
        <button class="btn btn-primary mt-3 w-100" @click="addNewCollection">Ok !</button>
      </div>
    </div>
  </div>
</template>
<script>
import DateInput from "~components/InputField/DateInput.vue";
import TextInput from "~components/InputField/TextInput.vue";
import { axsIns } from "../../../../js/bootstrap";
export default {
  components: {
    TextInput,
    DateInput,
  },
  emits: ["updateCatalogIndex", "updateCollectionIndex"],
  data() {
    return {
      nameCategory: "",

      collectionAddingInstance: {
        nameValue: "",
        startDate: "",
        endDate: "",
      },
      tabCatalogCollection: {
        whichTab: "catalogue",
      },
      notification: {
        isDone: false,
        isError: false,
        message: "",
        alertAnimate: "",
      },
    };
  },
  watch: {
    "tabCatalogCollection.whichTab": {
      handler(newVal) {
        this.$nextTick(() => {
          if (newVal === "catalogue") {
            this.$refs.tabCatalog.scrollIntoView({ behavior: "smooth", block: "center" });
          } else if (newVal === "collection") {
            this.$refs.tabCollection.scrollIntoView({ behavior: "smooth", block: "center" });
          }
        });
      },
    },
  },
  methods: {
    handleWithCCTab(tab) {
      this.tabCatalogCollection.whichTab = tab;
    },
    async addNewCatalog() {
      if (this.nameCategory === "") {
        this.notify("Catalog must have a name !", "isError");
        return;
      }
      try {
        const catalogResponse = await axsIns.post("/api/categories", { name: this.nameCategory });
        if (catalogResponse.status === 200) {
          this.$emit("updateCatalogIndex", catalogResponse.data);
          this.notify("Add new Catalogue !", "isDone");
          this.nameCategory = "";
        }
      } catch (error) {
        this.notify(error.response.data.erros, "isError");
      }
    },
    async addNewCollection() {
      if (this.collectionAddingInstance.nameValue === "") {
        this.notify("Collection must have a name !", "isError");
        return;
      }
      try {
        const collectionResponse = await axsIns.post("/api/collections", {
          name: this.collectionAddingInstance.nameValue,
          startAt: this.collectionAddingInstance.startDate,
          endAt: this.collectionAddingInstance.endDate,
        });
        if (collectionResponse.status === 200) {
          this.$emit("updateCollectionIndex", collectionResponse.data);
          this.notify("Add new Collection !", "isDone");
          this.collectionAddingInstance.nameValue = "";
          this.collectionAddingInstance.startDate = "";
          this.collectionAddingInstance.endDate = "";
        }
      } catch (error) {
        console.log(error);
        this.notify(error.response.data.erros, "isError");
      }
    },
    notify(message, typeNotice) {
      this.notification[typeNotice] = true;
      this.notification.message = message;
      this.notification.alertAnimate = "animate__fadeIn";
      setTimeout(() => {
        this.notification[typeNotice] = false;
        this.notification.message = "";
        this.notification.alertAnimate = "";
      }, 5000);
    },
  },
};
</script>
<style></style>
