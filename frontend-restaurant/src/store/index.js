import { createStore } from "vuex";
import auth from "./modules/auth";
import order from "./modules/order";
import profile from "./modules/profile";
import category from "./modules/category";

export default createStore({
  modules: {
    auth,
    order,
    profile,
    category,
  },
});
