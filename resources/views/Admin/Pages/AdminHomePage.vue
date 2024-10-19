<template>
  <div class="homepage-container">
    <h3 class="text-center mb-3 text-primary">Manage User</h3>
    <!-----------------------Select Group Row----------------------->
    <div class="row select-group">
      <div class="col-lg-3 filter-select">
        <label for="role_filter" class="form-label fw-bold">Filter Role</label>
        <select class="form-select" aria-label="Default select example" id="role_filter">
          <option selected>Open this select menu</option>
          <option value="1">One</option>
          <option value="2">Two</option>
          <option value="3">Three</option>
        </select>
      </div>
      <div class="col-lg-3 filter-select">
        <label for="createdAt_filter" class="form-label fw-bold">Filter Created By</label>
        <select class="form-select" aria-label="Default select example" id="createdAt_filter">
          <option selected>Open this select menu</option>
          <option value="1">One</option>
          <option value="2">Two</option>
          <option value="3">Three</option>
        </select>
      </div>
      <div class="col-lg-3 filter-select">
        <label for="updatedAt_filter" class="form-label fw-bold">Filter Updated By</label>
        <select class="form-select" aria-label="Default select example" id="updatedAt_filter">
          <option selected>Open this select menu</option>
          <option value="1">One</option>
          <option value="2">Two</option>
          <option value="3">Three</option>
        </select>
      </div>
      <div class="col-lg-3 filter-select">
        <label for="updatedAt_filter" class="form-label fw-bold">Filter Deleted By</label>
        <select class="form-select" aria-label="Default select example" id="updatedAt_filter">
          <option selected>Open this select menu</option>
          <option value="1">One</option>
          <option value="2">Two</option>
          <option value="3">Three</option>
        </select>
      </div>
    </div>
    <!-------------Button Group Manage User Row----------------->
    <div class="row button-manage">
      <div class="col-lg-4">
        <label for="add_user" class="form-label fw-bold">Add User</label><br />
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="add_user">
          Add New User
        </button>
        <AddOrEditUser></AddOrEditUser>
      </div>
    </div>
    <div class="table-container w-100">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Role</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Config</th>
            <th>Deleted At</th>
          </tr>
        </thead>
        <tbody class="table-group-divider">
          <tr>
            <th>1</th>
            <td>admin</td>
            <td>admin@gmail.com</td>
            <td>0123456789</td>
            <td>owner</td>
            <td>2024-09-02 11:26:41</td>
            <td>2024-09-02 11:26:41</td>
            <td>
              <div class="config-button-group">
                <button class="btn btn-outline-warning btn-sm me-2">Edit</button>
                <button class="btn btn-outline-danger btn-sm">Delete</button>
              </div>
            </td>
            <td>2024-09-02 11:26:41</td>
          </tr>
        </tbody>
      </table>
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
import AddOrEditUser from "~components/AddOrEditUser.vue";

export default {
  components: {
    AddOrEditUser,
  },
  data() {
    return {
      usersData: [],
    };
  },
  computed: {},
  watch: {},
  created() {},
  mounted() {
    try {
      const response = axios.get("/api/users");
      if (response.status === 200) {
        this.usersData = response.data.users_data;
      }
    } catch (error) {
      console.log(error);
    }
  },
  methods: {},
};
</script>

<style>
.homepage-container {
}
.select-group {
  margin-bottom: 24px;
}
.button-manage {
  margin-bottom: 24px;
}
.table-container {
  margin-bottom: 24px;
  overflow-x: scroll;
}
.table {
  width: 120%;
}
</style>
