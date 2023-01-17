export default [
  {
    name: "BookList",
    path: "/books/",
    component: () => import("../components/book/List.vue"),
  },
  {
    name: "BookCreate",
    path: "/books/create",
    component: () => import("../components/book/Create.vue"),
  },
  {
    name: "BookUpdate",
    path: "/books/edit/:id",
    component: () => import("../components/book/Update.vue"),
  },
  {
    name: "BookShow",
    path: "/books/show/:id",
    component: () => import("../components/book/Show.vue"),
  },
];
