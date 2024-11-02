const adminRoutes = [
  {
    path: "/admin",
    name: "admin-homepage",
    meta: { requiresAuth: true },
    component: () => import("~views/Admin/Pages/AdminHomePageUM.vue"),
  },
  // ~views/Admin/Pages/AdminHomePageUM.vue
  {
    path: "/admin/product",
    meta: { requiresAuth: true },
    component: () => import("~views/Admin/Pages/AdminProductManagement.vue"),
    children: [
      {
        path: "",
        name: "admin-product",
        component: () => import("~views/Admin/Pages/ProductsComponent/AdminProducts.vue"),
        meta: { requiresAuth: true },
      },
      {
        path: "add",
        name: "admin-add-product",
        component: () => import("~views/Admin/Pages/ProductsComponent/AdminAddProduct.vue"),
        meta: { requiresAuth: true },
      },
      {
        path: "edit",
        name: "admin-edit-product-origin",
        component: () => import("~views/Admin/Pages/ProductsComponent/AdminEditProduct.vue"),
        meta: { requiresAuth: true },
      },
      {
        path: "edit/:id",
        name: "admin-edit-product",
        component: () => import("~views/Admin/Pages/ProductsComponent/AdminEditProduct.vue"),
        meta: { requiresAuth: true },
      },
    ],
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
