import { createWebHistory, createRouter } from "vue-router";
import Home from "../pages/Home.vue";
import Login from "../pages/Login.vue";
import Register from "../pages/Register.vue";
import { useAuthStore } from "../stores/auth";

// lazy-loaded
const Profile = () => import("../pages/Profile.vue");
const Admin = () => import("../pages/Admin.vue");
const Verify = () => import("../pages/Verify.vue");
const Events = () => import("../pages/Events.vue");

const routes = [
  {
    path: "/",
    name: "home",
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
    path: "/verify",
    name: "verify",
    component: Verify,
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

  {
    path: "/events",
    name: "events",
    // lazy-loaded
    component: Events,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach(async ({ name, query }, _from, next) => {
  const authStore = useAuthStore();
  const authRoutes = ["login", "register", "verify"];
  const publicRoutes = [...authRoutes, "home"];
  const isAuth = authRoutes.includes(name);
  const isPublic = publicRoutes.includes(name);

  if (name === "verify") {
    const { token } = query;

    if (!token) {
      return next({ name: "home" });
    }

    await authStore.verify(token);
  }

  if (!authStore.isAttempted) {
    await authStore.attempt();
  }

  if (!isPublic && !authStore.isAuthenticated) {
    return next({ name: "login" });
  }

  if (isAuth && authStore.isAuthenticated) {
    return next({ name: "profile" });
  }

  next();
});

export default router;
