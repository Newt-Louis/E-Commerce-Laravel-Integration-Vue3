

const adminRoutes = [
  {
    path: '/admin',
    name:'admin-homepage',
    meta: {requiresAuth: true},
    component:() => import('../../views/Admin/Pages/AdminHomePage.vue'),
  },
  {
    path:'/admin/user-management',
    name:'user-management',
    meta: {requiresAuth: true},
    component: () => import('../../views/Admin/Pages/UserManagement.vue')
  },
  {
    path: '/admin/login',
    name: 'login-admin',
    meta: {requiresAuth: false},
    components:{
      login: () => import('../../views/Admin/Pages/Login.vue')
    },
  },
]

export default adminRoutes;