const routes = [
  {
    path: '/',
    name: 'homepage',
    component: () => import('../../views/Pages/HomePage.vue'),
  },
  {
    path: '/about',
    name: 'about',
    component: () => import('../../views/Pages/About.vue'),
  },
]

export default routes;