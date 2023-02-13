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
import ListEvents from "../pages/ListEvents.vue";
import Fidelitycard from "../pages/FidelityCard.vue";
import { useAuthStore } from "../stores/auth";

// lazy-loaded
const Profile = () => import("../pages/Profile.vue");
const Verify = () => import("../pages/Verify.vue");
const Join = () => import("../pages/Join.vue");
const Upload = () => import("../pages/Upload.vue");
const UpdatePassword = () => import("../pages/UpdatePassword.vue");
const ResetPassword = () => import("../pages/ResetPassword.vue");
const Admin = () => import("../pages/Admin/Admin.vue");
const AdminTheaterGroups = () => import("../pages/Admin/TheaterGroups.vue");
const AdminTheaterGroup = () => import("../pages/Admin/TheaterGroup.vue");
const AdminUsers = () => import("../pages/Admin/Users.vue");
const AdminUser = () => import("../pages/Admin/User.vue");
const NotFound = () => import("../pages/Errors/NotFound.vue");
const TheaterGroup = () => import("../pages/TheaterGroup/TheaterGroup.vue");
const TheaterGroupEvents = () => import("../pages/TheaterGroup/Events.vue");
const TheaterGroupEvent = () => import("../pages/TheaterGroup/Event.vue");
const TheaterGroupInformation = () =>
  import("../pages/TheaterGroup/Information.vue");

const routes = [
  {
    path: "/",
    name: "home",
    component: Home,
  },
  {
    path: "/events",
    name: "events",
    component: ListEvents,
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
    path: "/theater-group/:theaterGroupId",
    name: "theater-group",
    component: TheaterGroup,
    props: ({ params }) => ({ theaterGroupId: params.theaterGroupId }),
    children: [
      {
        path: "",
        name: "theater-group",
        component: TheaterGroupInformation,
        props: ({ params }) => ({ theaterGroupId: params.theaterGroupId }),
      },
      {
        path: "events",
        name: "theater-group-events",
        component: TheaterGroupEvents,
        props: ({ params }) => ({ theaterGroupId: params.theaterGroupId }),
      },
      {
        path: "event/:eventId",
        name: "theater-group-event",
        component: TheaterGroupEvent,
        props: ({ params }) => ({
          theaterGroupId: params.theaterGroupId,
          eventId: params.eventId,
        }),
      },
    ],
  },
  {
    path: "/admin",
    name: "admin",
    component: Admin,
    children: [
      {
        path: "theater-groups",
        name: "admin-theater-groups",
        component: AdminTheaterGroups,
      },
      {
        path: "theater-group/:theaterGroupId",
        name: "admin-theater-group",
        component: AdminTheaterGroup,
        props: ({ params }) => ({ theaterGroupId: params.theaterGroupId }),
      },
      {
        path: "users",
        name: "admin-users",
        component: AdminUsers,
      },
      {
        path: "user/:userId",
        name: "admin-user",
        component: AdminUser,
        props: ({ params }) => ({ userId: params.userId }),
      },
    ],
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

router.beforeEach(async ({ name, path, query }, _from, next) => {
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
    "cgv",
    "events",
  ];

  const isAuthRoute = authRoutes.includes(name);
  const isPublicRoute = publicRoutes.includes(name);
  const isAdminRoute = path.startsWith("/admin");

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

  if (isAdminRoute && !authStore.user?.isAdmin) {
    return next({ name: "not-found" });
  }

  next();
});

export default router;
