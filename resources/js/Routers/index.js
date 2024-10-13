import { createRouter, createWebHistory } from "vue-router";
import routes from "./routes";
import adminRoutes from "./adminRoutes";
import { useAdminUserStore } from "../Admin/piniaStores/userAdminStore";
const routerClient = createRouter({
  history: createWebHistory(),
  routes: routes,
});

const routerAdmin = createRouter({
  history: createWebHistory(),
  routes: adminRoutes,
});

routerAdmin.beforeEach((to, from, next) => {
  const adminUserStore = useAdminUserStore();
  if (!adminUserStore.checkLogin && to.meta.requiresAuth) {
    next({ name: "auth" });
  } else {
    next();
  }
});
export { routerClient, routerAdmin };
