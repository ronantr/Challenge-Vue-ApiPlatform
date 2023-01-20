import { createApp } from "vue";
import { createPinia } from "pinia";
import { FontAwesomeIcon } from "./plugins";
import App from "./App.vue";
import router from "./router";
import "./index.css";

const app = createApp(App);
const pinia = createPinia();

app.use(pinia);
app.use(router);

app.component("font-awesome-icon", FontAwesomeIcon);

app.mount("#app");
