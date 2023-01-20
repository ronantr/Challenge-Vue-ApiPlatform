import { createWebHistory, createRouter } from "vue-router";
import Home from "../components/Home.vue";
import Login from "../components/Login.vue";
import Register from "../components/Register.vue";
import { useAuthStore } from "../stores/auth";
// lazy-loaded
const Profile = () => import("../components/Profile.vue");
const BoardAdmin = () => import("../components/BoardAdmin.vue");
const BoardModerator = () => import("../components/BoardModerator.vue");
const BoardUser = () => import("../components/BoardUser.vue");

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
    component: BoardAdmin,
  },
  {
    path: "/mod",
    name: "moderator",
    // lazy-loaded
    component: BoardModerator,
  },
  {
    path: "/user",
    name: "user",
    // lazy-loaded
    component: BoardUser,
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
