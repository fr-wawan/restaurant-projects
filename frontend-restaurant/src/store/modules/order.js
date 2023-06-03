import Api from "../../api/Api";

const order = {
  //set namespace true
  namespaced: true,

  //state
  state: {
    orders: [],
    order: {},
    nextExists: false,
    nextPage: 0,
  },

  //mutations
  mutations: {
    SET_ORDERS(state, orders) {
      state.orders = orders;
    },

    DETAIL_ORDER(state, order) {
      state.order = order;
    },

    SET_NEXTEXISTS(state, nextExists) {
      state.nextExists = nextExists;
    },

    SET_NEXTPAGE(state, nextPage) {
      state.nextPage = nextPage;
    },

    SET_LOADMORE(state, data) {
      data.forEach((row) => {
        state.orders.push(row);
      });
    },
  },

  //actions
  actions: {
    getOrder({ commit }) {
      const token = localStorage.getItem("token");

      Api.defaults.headers.common["Authorization"] = `Bearer ${token}`;

      Api.get("/transaction")
        .then((response) => {
          commit("SET_ORDERS", response.data.data.data);

          if (response.data.data.current_page < response.data.data.last_page) {
            commit("SET_NEXTEXISTS", true);

            commit("SET_NEXTPAGE", response.data.data.current_page + 1);
          } else {
            commit("SET_NEXTEXISTS", false);
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    getLoadMore({ commit }, nextPage) {
      const token = localStorage.getItem("token");

      Api.defaults.headers.common["Authorization"] = `Bearer ${token}`;

      Api.get(`/transaction?page=${nextPage}`)
        .then((response) => {
          commit("SET_LOADMORE", response.data.data.data);

          if (response.data.data.current_page < response.data.data.last_page) {
            commit("SET_NEXTEXISTS", true);

            commit("SET_NEXTPAGE", response.data.data.current_page + 1);
          } else {
            commit("SET_NEXTEXISTS", false);
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    storeOrder({ commit }, formData) {
      return new Promise((resolve, reject) => {
        const token = localStorage.getItem("token");
        Api.defaults.headers.common["Authorization"] = `Bearer ${token}`;

        Api.post("/transaction", formData)
          .then((response) => {
            resolve(response);
          })
          .catch((error) => {
            reject(error.response.data);
          });
      });
    },
    detailOrders({ commit }, invoice) {
      Api.get(`/transaction/${invoice}`)
        .then((response) => {
          commit("DETAIL_ORDER", response.data.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },

  //getters
  getters: {},
};

export default order;
