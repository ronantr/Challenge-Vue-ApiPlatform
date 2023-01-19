import { createApp } from "vue";
import { createPinia } from "pinia";
import App from "./App.vue";
import router from "./router";

// import "bootstrap";
// import "bootstrap/dist/css/bootstrap.min.css";
// import "./assets/main.css";

import "./index.css";
const app = createApp(App);
const pinia = createPinia();

app.use(router);
app.use(pinia);
app.component("font-awesome-icon", FontAwesomeIcon);
app.mount("#app");
