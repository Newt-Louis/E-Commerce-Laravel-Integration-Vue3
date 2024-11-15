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
      <div class="scroll-table w-100">
        <table class="table table-hover caption-top">
          <caption>
            List of Products
          </caption>
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">First</th>
              <th scope="col">Last</th>
              <th scope="col">Handle</th>
              <th scope="col">Handle</th>
              <th scope="col">Handle</th>
              <th scope="col">Handle</th>
              <th scope="col">Handle</th>
              <th scope="col">Handle</th>
              <th scope="col">Handle</th>
              <th scope="col">Handle</th>
              <th scope="col">Handle</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>Mark</td>
              <td>Otto</td>
              <td>@mdo</td>
              <td>Jacob</td>
              <td>Thornton</td>
              <td>@fat</td>
              <td>Larry the Bird</td>
              <td>@twitter</td>
              <td>@twittádfsfsdfgdfgdfer</td>
              <td>@twitter</td>
              <td>@twitter</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="pagination-container float-end">
      <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-end">
          <li class="page-item disabled">
            <a class="page-link">Previous</a>
          </li>
          <li class="page-item"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item">
            <a class="page-link" href="#">Next</a>
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
    };
  },
  computed: {},
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
  methods: {},
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
  width: 150%;
}
</style>
