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
  {
    path: '/admin',
    name: 'admin',
    component: () => import('../../views/Admin/Pages/AdminHomePage.vue'),
  }
]

export default routes;