import {createMemoryHistory, createRouter, createWebHistory} from "vue-router";
import routes from "./routes";

const routerClient = createRouter({
  history: createWebHistory(),
  routes: routes,
})

const routerAdmin = createRouter({
  history: createMemoryHistory(),
  routes: [
    {
      path:'',
      component:() => import('../../views/AdminApp.vue'),
      // redirect: '/admin',
    },
    // {
    //   path:'/admin',
    //   name:'admin',
    // }
  ]
})

export {routerClient,routerAdmin}