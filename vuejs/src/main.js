import "./index.css";
import "vue3-easy-data-table/dist/style.css";
import { createApp } from "vue";
import { createPinia } from "pinia";
import EasyDataTable from "vue3-easy-data-table";
import { FontAwesomeIcon, toast } from "./plugins";
import App from "./App.vue";
import router from "./router";

const app = createApp(App);
const pinia = createPinia();

app.use(pinia);
app.use(router);
app.use(toast);

app.component("FontAwesomeIcon", FontAwesomeIcon);
app.component("EasyDataTable", EasyDataTable);

app.mount("#app");
