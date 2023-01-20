import { createWebHistory, createRouter } from "vue-router";
import Home from "../pages/Home.vue";
import Login from "../pages/Login.vue";
import Register from "../pages/Register.vue";
import { useAuthStore } from "../stores/auth";
// lazy-loaded
const Profile = () => import("../pages/Profile.vue");
const Admin = () => import("../pages/Admin.vue");

const routes = [
  {
    path: "/",
    name: "home",
    component: Home,
  },
  {
    path: "/home",
    component: Home,
  },
  {
    path: "/login",
    name: "login",
    component: Login,
  },
  {
    path: "/register",
    name: "register",
    component: Register,
  },
  {
    path: "/profile",
    name: "profile",
    // lazy-loaded
    component: Profile,
  },
  {
    path: "/admin",
    name: "admin",
    // lazy-loaded
    component: Admin,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach(async (to, _from, next) => {
  const authStore = useAuthStore();
  const publicPaths = ["/login", "/register", "/home"];
  const isPublic = publicPaths.includes(to.path);

  if (!authStore.isAttempted) {
    await authStore.attempt();
  }

  if (!isPublic && !authStore.isAuthenticated) {
    return next({ name: "login" });
  }

  if (isPublic && authStore.isAuthenticated) {
    return next({ name: "home" });
  }

  next();
});

export default router;
