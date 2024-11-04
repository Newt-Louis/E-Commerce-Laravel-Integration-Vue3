<template>
  <div>
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
        <TextInput :placeholder="`Write catalog name ...`" :text-input-name="'add-catalog'"></TextInput>
        <button class="btn btn-primary mt-3 w-100">Ok !</button>
      </div>
      <div
        class="tab-collection-container animate__animated"
        :class="{ animate__fadeIn: tabCatalogCollection.whichTab === 'collection' }"
        v-if="tabCatalogCollection.whichTab === 'collection'"
      >
        <label for="" class="form-label">Add new collection</label>
        <TextInput :placeholder="`Write collection name ...`" :text-input-name="'add-catalog'"></TextInput>
        <label for="" class="form-label">Start date</label>
        <DateInput></DateInput>
        <label for="" class="form-label">End date</label>
        <DateInput></DateInput>
        <button class="btn btn-primary mt-3 w-100">Ok !</button>
      </div>
    </div>
  </div>
</template>
<script>
import DateInput from "~components/InputField/DateInput.vue";
import TextInput from "~components/InputField/TextInput.vue";
export default {
  components: {
    TextInput,
    DateInput,
  },
  data() {
    return {
      tabCatalogCollection: {
        whichTab: "catalogue",
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
  },
};
</script>
<style></style>
