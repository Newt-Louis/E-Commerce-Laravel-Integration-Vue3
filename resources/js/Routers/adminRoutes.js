const adminRoutes = [
  {
    path: "/admin",
    name: "admin-homepage",
    meta: { requiresAuth: true },
    component: () => import("~views/Admin/Pages/AdminHomePage.vue"),
  },
  {
    path: "/admin/user-management",
    name: "user-management",
    meta: { requiresAuth: true },
    component: () => import("~views/Admin/Pages/UserManagement.vue"),
  },
  {
    path: "/admin/login",
    name: "login-admin",
    meta: { requiresAuth: false },
    components: {
      login: () => import("~views/Admin/Pages/Login.vue"),
    },
  },
  {
    path: "/admin/authentication",
    name: "auth",
    meta: { requiresAuth: false },
    components: import("~views/Components/Authentication.vue"),
  },
];

export default adminRoutes;
