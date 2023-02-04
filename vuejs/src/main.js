import "./index.css";
import { createApp } from "vue";
import { createPinia } from "pinia";
import { FontAwesomeIcon, toast } from "./plugins";
import App from "./App.vue";
import router from "./router";

const app = createApp(App);
const pinia = createPinia();

app.use(pinia);
app.use(router);
app.use(toast);

app.component("font-awesome-icon", FontAwesomeIcon);

app.mount("#app");
