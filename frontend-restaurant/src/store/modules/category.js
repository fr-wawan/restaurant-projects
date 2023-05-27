import Api from "../../api/Api";

const category = {
  //set namespace true
  namespaced: true,

  //state
  state: {
    categories: [],
    foodCategory: [],
    category: {},
  },

  //mutations
  mutations: {
    SET_CATEGORIES(state, data) {
      state.categories = data;
    },

    DETAIL_CATEGORY(state, data) {
      state.category = data;
    },

    FOOD_CATEGORY(state, data) {
      state.foodCategory = data;
    },
  },

  //actions
  actions: {
    getCategoryHome({ commit }) {
      Api.get("/categoryHome")
        .then((response) => {
          commit("SET_CATEGORIES", response.data.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getDetailCategory({ commit }, slug) {
      Api.get(`/category/${slug}`)
        .then((response) => {
          commit("DETAIL_CATEGORY", response.data.data);
          commit("FOOD_CATEGORY", response.data.data.food);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getCategory({ commit }) {
      Api.get("/category")
        .then((response) => {
          commit("SET_CATEGORIES", response.data.data.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },

  //getters
  getters: {},
};

export default category;
