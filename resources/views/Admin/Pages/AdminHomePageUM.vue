<template>
  <div class="homepage-container">
    <h2 class="text-center mb-3 text-primary">Manage User</h2>
    <!-----------------------Select Group Row----------------------->
    <div class="row select-group">
      <div class="col-lg-3 filter-select">
        <label for="role_filter" class="form-label fw-bold">Filter Role</label>
        <select class="form-select" aria-label="Default select example" id="role_filter" multiple v-model="filterRole">
          <option selected value="">All</option>
          <option v-for="(role, index) in usersRole" :value="role.id" :key="index">{{ role.description }}</option>
        </select>
      </div>
      <div class="col-lg-3 filter-select">
        <label for="createdAt_filter" class="form-label fw-bold">Filter Created By</label>
        <select class="form-select" aria-label="Default select example" id="createdAt_filter" v-model="sortCreated">
          <option selected value="">Open this select menu</option>
          <option value="asc">Acsending</option>
          <option value="desc">Descending</option>
        </select>
      </div>
      <div class="col-lg-3 filter-select">
        <label for="updatedAt_filter" class="form-label fw-bold">Filter Updated By</label>
        <select class="form-select" aria-label="Default select example" id="updatedAt_filter">
          <option selected>Open this select menu</option>
          <option value="1">Acsending</option>
          <option value="2">Descending</option>
        </select>
      </div>
      <div class="col-lg-3 filter-select">
        <label for="updatedAt_filter" class="form-label fw-bold">Filter Deleted By</label>
        <select class="form-select" aria-label="Default select example" id="updatedAt_filter">
          <option selected>Open this select menu</option>
          <option value="1">Acsending</option>
          <option value="2">Descending</option>
        </select>
      </div>
    </div>
    <!-------------Button Group Manage User Row----------------->
    <div class="row button-manage">
      <div class="col-lg-4">
        <label for="add_user" class="form-label fw-bold">Add User</label><br />
        <button
          class="btn btn-outline-primary"
          data-bs-toggle="modal"
          data-bs-target="#addOrEditUser"
          id="add_user"
          @click="addingUser"
        >
          Add New User
        </button>
        <AddOrEditUser
          :isAdd="isAdd"
          :user-data="userEditing"
          :isValidateStateOn="validate"
          @close-modal="handleOnCloseModal"
          @update-users-data="getDataUpdate"
        ></AddOrEditUser>
      </div>
    </div>
    <div class="table-container w-100">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Avatar</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Role</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Config</th>
            <!-- <th v-if="user?.deleted_at ? true : false">Deleted At</th> -->
          </tr>
        </thead>
        <tbody v-if="usersData.length > 0" class="table-group-divider">
          <tr v-for="(user, index) in filteredUsers" :key="index">
            <th>{{ user.id }}</th>
            <td>
              <img :src="user.avatar ? user.avatar : '/blank_avatar.jpg'" :alt="user.name" class="array-avatar-user" />
            </td>
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.phone }}</td>
            <td>
              {{ user.role.description }}
            </td>
            <td>{{ user.created_at ? user.created_at : "None" }}</td>
            <td>{{ user.updated_at ? user.updated_at : "None" }}</td>

            <td>
              <div class="config-button-group">
                <button
                  class="btn btn-outline-warning btn-sm me-2"
                  @click="editingUser(user.id)"
                  data-bs-toggle="modal"
                  data-bs-target="#addOrEditUser"
                  id="edit_user"
                >
                  Edit
                </button>
                <button class="btn btn-outline-danger btn-sm" @click="deleteUser(user.id)" id="delete_user">
                  Delete
                </button>
              </div>
            </td>
            <td v-if="user?.deleted_at ? true : false">{{ user.deleted_at }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="pagination-container float-end">
      <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-end">
          <li class="page-item" v-for="(link, index) in linksPaginate" :key="index">
            <a
              :class="`page-link ${link.url === null ? 'disabled' : link.active ? 'active' : ''}`"
              @click="handlePagination(link.url)"
            >
              {{ formattedLabel(link.label) }}
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</template>

<script>
import AddOrEditUser from "~components/AddOrEditUser.vue";
import { axsIns } from "../../../js/bootstrap";
export default {
  components: {
    AddOrEditUser,
  },
  data() {
    return {
      usersData: [],
      usersRole: [],
      filterRole: [],
      sortCreated: "",
      sortUpdated: "",
      sortDeleted: "",
      isAdd: true,
      userEditing: { idUser: 0, name: "", email: "", phone: "", role: "", avatar: [] },
      validate: true,
      linksPaginate: [],
    };
  },
  computed: {
    filteredUsers() {
      let result = [...this.usersData];
      if (this.sortCreated !== "") {
        result = this.sortCreatedAt(this.sortCreated, result);
      }
      if (this.filterRole.length > 0 && this.filterRole[0] !== "") {
        result = this.filteredByRole(this.filterRole, result);
      }
      return result;
    },
    formattedLabel() {
      return (label) => {
        return label.replace("&laquo;", "").replace("&raquo;", "");
      };
    },
  },
  created() {},
  async mounted() {
    try {
      const [usersResponse, rolesResponse] = await Promise.all([axsIns.get("/api/users"), axsIns.get("api/roles")]);
      if (usersResponse.status === 200) {
        console.log(usersResponse);
        this.linksPaginate = usersResponse.data.meta.links;
        this.usersData = usersResponse.data.data;
      }
      if (rolesResponse.status === 200) {
        this.usersRole = rolesResponse.data;
      }
    } catch (error) {
      console.log(error);
    }
  },
  methods: {
    sortCreatedAt(sortBy, data) {
      this.sortUpdated.isSort = false;
      this.sortDeleted.isSort = false;
      if (sortBy === "asc") {
        data.sort((a, b) => {
          const date1 = new Date(a.created_at);
          const date2 = new Date(b.created_at);
          return date1 - date2;
        });
      } else if (sortBy === "desc") {
        data.sort((a, b) => {
          const date1 = new Date(a.created_at);
          const date2 = new Date(b.created_at);
          return date2 - date1;
        });
      }

      return data;
    },
    filteredByRole(filterArray, data) {
      const result = [];
      if (filterArray.length > 0) {
        for (let i = 0; i < data.length; i++) {
          for (let j = 0; j < filterArray.length; j++) {
            if (data[i].role_id == filterArray[j]) {
              result.push(data[i]);
              break;
            }
          }
        }
      } else {
        return data;
      }
      return result;
    },
    test() {
      console.log(this.filterRole);
    },
    addingUser() {
      this.isAdd = true;
      this.validate = true;
      this.userEditing.idUser = 0;
      this.userEditing.name = "";
      this.userEditing.email = "";
      this.userEditing.phone = "";
      this.userEditing.role = "";
      this.userEditing.avatar = [];
    },
    editingUser(id) {
      this.isAdd = false;
      this.validate = true;
      this.userEditing.avatar = [];
      const userById = this.usersData.find((user) => user.id === id);
      this.userEditing.idUser = userById.id;
      this.userEditing.name = userById.name;
      this.userEditing.email = userById.email;
      this.userEditing.phone = userById.phone;
      this.userEditing.role = userById.role_id;
      if (userById?.avatar) {
        this.userEditing.avatar.push(userById.avatar);
      }
      console.log(this.userEditing);
    },
    async deleteUser(id) {
      try {
        const response = await axsIns.delete("api/users/" + id);
        if (response.status === 200) {
          this.usersData = response.data;
        }
      } catch (error) {
        console.log(error);
      }
    },
    getDataUpdate(data) {
      this.usersData = data;
    },
    handleOnCloseModal(data) {
      this.validate = data.validateState;
    },
    async handlePagination(url) {
      if (url) {
        try {
          const response = await axsIns.get(url);
          if (response.status === 200) {
            this.usersData = response.data.data;
            this.linksPaginate = response.data.meta.links;
          }
        } catch (error) {
          console.log(error);
        }
      }
    },
  },
};
</script>

<style>
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
.array-avatar-user {
  max-width: 50px;
  max-height: 50px;
  border-radius: 50%;
  object-fit: contain;
}
.page-link:hover {
  cursor: pointer;
}
</style>
