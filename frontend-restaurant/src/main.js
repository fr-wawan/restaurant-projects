import { createApp } from "vue";
import App from "./App.vue";

/**
 * import Toastr
 */
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

/**
 * Tailwind CSS
 */
import "./style.css";
import mixins from "./mixins";

import router from "./router";

import store from "./store";

//create App Vue
const app = createApp(App);

app.use(Toast);

app.mixin(mixins);

app.use(router);

app.use(store);

app.mount("#app");
