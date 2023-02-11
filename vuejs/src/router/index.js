import { createWebHistory, createRouter } from "vue-router";
import Home from "../pages/Home.vue";
import Login from "../pages/Login.vue";
import Register from "../pages/Register.vue";
import About from "../pages/About.vue";
import Contact from "../pages/Contact.vue";
import LegalNotices from "../pages/LegalNotices.vue";
import PrivacyPolicy from "../pages/PrivacyPolicy.vue";
import Faq from "../pages/Faq.vue";
import Cart from "../pages/Cart.vue";
import Cgv from "../pages/Cgv.vue";
import Fidelitycard from "../pages/FidelityCard.vue";
import { useAuthStore } from "../stores/auth";

// lazy-loaded
const Profile = () => import("../pages/Profile.vue");
const Admin = () => import("../pages/Admin.vue");
const Verify = () => import("../pages/Verify.vue");
const UpdatePassword = () => import("../pages/UpdatePassword.vue");
const ResetPassword = () => import("../pages/ResetPassword.vue");

const routes = [
  {
    path: "/",
    name: "home",
    component: Home,
  },
  {
    path: "/about",
    name: "about",
    component: About,
  },
  {
    path: "/legalnotices",
    name: "legalnotices",
    component: LegalNotices,
  },
  {
    path: "/faq",
    name: "faq",
    component: Faq,
  },
  {
    path: "/privacypolicy",
    name: "privacypolicy",
    component: PrivacyPolicy,
  },
  {
    path: "/cgv",
    name: "cgv",
    component: Cgv,
  },
  {
    path: "/fidelitycard",
    name: "fidelitycard",
    component: Fidelitycard,
  },
  {
    path: "/contact",
    name: "contact",
    component: Contact,
  },
  {
    path: "/cart",
    name: "cart",
    component: Cart,
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

router.beforeEach(async ({ name, query }, _from, next) => {
  const authStore = useAuthStore();
  const authRoutes = ["login", "register", "verify"];
  const publicRoutes = [
    ...authRoutes,
    "home",
    "update-password",
    "reset-password",
    "about",
    "contact",
    "faq",
    "legalnotices",
    "privacypolicy",
    "fidelitycard",
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
