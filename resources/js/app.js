import "./bootstrap";
import "../css/app.css";
import { createApp } from "vue";
import { createPinia } from "pinia";
import App from "../views/App.vue";
import axios from "axios";
window.axios = axios;
import { routerClient } from "../js/Routers/index.js";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";

import "animate.css";
const app = createApp(App);
const pinia = createPinia();
app.use(routerClient);
app.use(pinia);
app.mount("#app");
