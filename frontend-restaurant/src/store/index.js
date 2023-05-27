import { createStore } from "vuex";
import auth from "./modules/auth";
import order from "./modules/order";
import profile from "./modules/profile";
import category from "./modules/category";
import food from "./modules/food";
import cart from "./modules/cart";

export default createStore({
  modules: {
    auth,
    order,
    profile,
    category,
    food,
    cart,
  },
});
