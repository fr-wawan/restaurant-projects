import Api from "../../api/Api";

const cart = {
  namespaced: true,

  state: {
    cart: [],
  },
  mutations: {
    SET_CART(state, data) {
      state.cart = data;
    },
  },

  actions: {
    storeCart({ commit }, formData) {
      return new Promise((resolve, reject) => {
        const token = localStorage.getItem("token");

        Api.defaults.headers.common["Authorization"] = `Bearer ${token}`;

        Api.post("/cart", formData)
          .then((response) => {
            commit("SET_CART", response.data.data);

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
        })
        .catch((error) => {
          console.log(error);
        });
    },

    deleteCart({ commit }, formData) {
      return new Promise((resolve, reject) => {
        const token = localStorage.getItem("token");

        Api.defaults.headers.common["Authorization"] = `Bearer ${token}`;

        Api.delete(`/cart/${formData}`)
          .then((response) => {
            commit("SET_CART", response.data.data);

            resolve(response);
          })
          .catch((error) => {
            reject(error.response.data);
          });
      });
    },
  },

  getters: {},
};

export default cart;
