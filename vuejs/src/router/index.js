import { createWebHistory, createRouter } from "vue-router";
import Home from "../pages/Home.vue";
import Login from "../pages/Login.vue";
import Register from "../pages/Register.vue";
import { useAuthStore } from "../stores/auth";

// lazy-loaded
const Profile = () => import("../pages/Profile.vue");
const Verify = () => import("../pages/Verify.vue");
const Join = () => import("../pages/Join.vue");
const Upload = () => import("../pages/Upload.vue");
const UpdatePassword = () => import("../pages/UpdatePassword.vue");
const ResetPassword = () => import("../pages/ResetPassword.vue");
const Theater = () => import("../pages/Theater.vue");
const NotFound = () => import("../pages/Errors/NotFound.vue");

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
    path: "/update-password",
    name: "update-password",
    component: UpdatePassword,
    props: ({ query }) => ({ token: query.token }),
    beforeEnter: ({ query }) => {
      const { token } = query;

      if (!token) {
        return { name: "home" };
      }
    },
  },
  {
    path: "/reset-password",
    name: "reset-password",
    component: ResetPassword,
  },
  {
    path: "/profile",
    name: "profile",
    // lazy-loaded
    component: Profile,
  },
  {
    path: "/join",
    name: "join",
    component: Join,
  },
  {
    path: "/upload",
    name: "upload",
    component: Upload,
  },
  {
    path: "/theater",
    name: "theater",
    component: Theater,
  },
  {
    path: "/:pathMatch(.*)*",
    name: "not-found",
    component: NotFound,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach(async ({ name, query }, _from, next) => {
  const authStore = useAuthStore();
  const authRoutes = ["login", "register", "verify"];
  const publicRoutes = [
    ...authRoutes,
    "home",
    "update-password",
    "reset-password",
  ];
  const isAuthRoute = authRoutes.includes(name);
  const isPublicRoute = publicRoutes.includes(name);

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

  if (!isPublicRoute && !authStore.isAuthenticated) {
    return next({ name: "login" });
  }

  if (isAuthRoute && authStore.isAuthenticated) {
    return next({ name: "profile" });
  }

  next();
});

export default router;
