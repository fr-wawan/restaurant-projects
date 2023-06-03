import Api from "../../api/Api";

const cart = {
  namespaced: true,

  state: {
    cart: [],
    count: {},
  },
  mutations: {
    SET_CART(state, data) {
      state.cart = data;
    },
    SET_COUNT(state, data) {
      state.count = data;
    },
    UPDATE_CART(state, updatedCart) {
      const index = state.cart.findIndex((c) => c.id === updatedCart.id);
      if (index !== -1) {
        state.cart[index].property1 = updatedCart.property1;
        state.cart[index].property2 = updatedCart.property2;

        if (updatedCart.hasOwnProperty("quantity")) {
          state.cart[index].quantity = updatedCart.quantity;
        }
      }
    },
  },

  actions: {
    storeCart({ dispatch }, formData) {
      return new Promise((resolve, reject) => {
        const token = localStorage.getItem("token");

        Api.defaults.headers.common["Authorization"] = `Bearer ${token}`;

        Api.post("/cart", formData)
          .then((response) => {
            dispatch("getCart");
            resolve(response);
          })
          .catch((error) => {
            reject(error.response.data);
          });
      });
    },

    getCart({ commit }) {
      const token = localStorage.getItem("token");

      Api.defaults.headers.common["Authorization"] = `Bearer ${token}`;
      Api.get("/cart")
        .then((response) => {
          commit("SET_CART", response.data.data);
          commit("SET_COUNT", response.data.count);
        })
        .catch((error) => {
          console.log(error);
        });
    },

    async updateCart({ commit }, formData) {
      try {
        const token = localStorage.getItem("token");
        Api.defaults.headers.common["Authorization"] = `Bearer ${token}`;

        const response = await Api.put(`/cart/${formData.id}`, formData);
        commit("UPDATE_CART", response.data.data);

        return response;
      } catch (error) {
        throw error.response.data;
      }
    },
    async deleteCart({ dispatch }, formData) {
      try {
        const token = localStorage.getItem("token");
        Api.defaults.headers.common["Authorization"] = `Bearer ${token}`;

        const response = await Api.delete(`/cart/${formData.id}`);

        dispatch("getCart");

        return response;
      } catch (error) {
        throw error.response.data;
      }
    },
  },

  getters: {
    cartTotal: (state) => {
      return state.cart
        .reduce((acc, cart) => {
          return cart.quantity * cart.food.price + acc;
        }, 0)
        .toFixed(2);
    },
  },
};

export default cart;
