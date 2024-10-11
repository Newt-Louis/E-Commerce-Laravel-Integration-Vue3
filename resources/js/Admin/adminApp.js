import "../bootstrap.js";
import { createApp } from "vue";
import { createPinia } from "pinia";
import AdminApp from "../../views/AdminApp.vue";
import { routerAdmin } from "../Routers/index.js";
import axios from "axios";
window.axios = axios;
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";
import "animate.css";
const appAdmin = createApp(AdminApp);
const pinia = createPinia();
appAdmin.use(routerAdmin);
appAdmin.use(pinia);

// axios.get("/api/auth/admin-remember");
appAdmin.mount("#appAdmin");
