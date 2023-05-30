import Api from "../../api/Api";

const food = {
  //set namespace true
  namespaced: true,

  //state
  state: {
    foods: [],

    food: {},

    nextExists: false,
    nextPage: 0,
  },

  //mutations
  mutations: {
    SET_FOOD(state, food) {
      state.foods = food;
    },

    DETAIL_FOOD(state, food) {
      state.food = food;
    },

    SET_NEXTEXISTS(state, nextExists) {
      state.nextExists = nextExists;
    },
    SET_NEXTPAGE(state, nextPage) {
      state.nextPage = nextPage;
    },
  },

  //actions
  actions: {
    getFood({ commit }) {
      Api.get("/food")
        .then((response) => {
          commit("SET_FOOD", response.data.data.data);

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
    detailsFood({ commit }, slug) {
      Api.get(`/food/${slug}`)
        .then((response) => {
          commit("DETAIL_FOOD", response.data.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },

  //getters
  getters: {},
};

export default food;
