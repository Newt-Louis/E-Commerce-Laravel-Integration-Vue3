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
      path:'/',
      name:'',
      children: [
        {
        path:'/admin',
        name:'admin',
        component:() => import('../../views/AdminApp.vue'),
        }
      ],
    }
  ]
})

export {routerClient,routerAdmin}