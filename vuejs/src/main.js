import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";

import "bootstrap";
import "bootstrap/dist/css/bootstrap.min.css";
import { FontAwesomeIcon } from "./plugins/font-awesome";
import "./assets/main.css";

const app = createApp(App);

app.use(router);
app.use(store);
app.component("font-awesome-icon", FontAwesomeIcon);
app.mount("#app");
