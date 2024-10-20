const adminRoutes = [
  {
    path: "/admin",
    name: "admin-homepage",
    meta: { requiresAuth: true },
    component: () => import("~views/Admin/Pages/AdminHomePageUM.vue"),
  },
  {
    path: "/admin/product",
    name: "admin-product",
    meta: { requiresAuth: true },
    component: () => import("~views/Admin/Pages/AdminProductManagement.vue"),
  },
  {
    path: "/admin/order",
    name: "admin-order",
    meta: { requiresAuth: true },
    component: () => import("~views/Admin/Pages/AdminClientOrderManagement.vue"),
  },
  {
    path: "/admin/purchase",
    name: "admin-purchase",
    meta: { requiresAuth: true },
    component: () => import("~views/Admin/Pages/AdminPurchaseManagement.vue"),
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
