import {createMemoryHistory, createRouter, createWebHistory} from "vue-router";
import routes from "./routes";
import adminRoutes from "./adminRoutes";

const routerClient = createRouter({
  history: createWebHistory(),
  routes: routes,
})

const routerAdmin = createRouter({
  history: createWebHistory(),
  routes: adminRoutes,
})

routerAdmin.beforeEach((to,from,next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    next({name: 'login-admin'})
  } else {
    next();
  }
})
export {routerClient,routerAdmin}