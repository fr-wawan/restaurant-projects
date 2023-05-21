import { createRouter, createWebHistory } from "vue-router";

import store from "../store";

const routes = [
  {
    path: "/register",
    name: "register",
    component: () => import("../views/auth/Register.vue"),
  },
  {
    path: "/login",
    name: "login",
    component: () => import("../views/auth/Login.vue"),
  },
  {
    path: "/dashboard",
    name: "dashboard",
    component: () => import("../views/dashboard/Index.vue"),
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: "/orders",
    name: "orders",
    component: () => import("../views/orders/Index.vue"),
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: "/profile",
    name: "profile",
    component: () => import("../views/profile/Index.vue"),
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: "/profile/password",
    name: "profile.password",
    component: () => import("../views/profile/Password.vue"),
    meta: {
      requiresAuth: true,
    },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    if (store.getters["auth/isLoggedIn"]) {
      next();
      return;
    }
    next("/login");
  } else {
    next();
  }
});

export default router;