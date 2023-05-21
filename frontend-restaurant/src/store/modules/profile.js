import Api from "../../api/Api";

const profile = {
  //set namespace true
  namespaced: true,

  //state
  state: {
    profile: {},
  },

  //mutations
  mutations: {
    SET_PROFILE(state, data) {
      state.profile = data;
    },
  },

  //actions
  actions: {
    getProfile({ commit }) {
      const token = localStorage.getItem("token");

      Api.defaults.headers.common["Authorization"] = `Bearer ${token}`;

      Api.get("/profile")
        .then((response) => {
          commit("SET_PROFILE", response.data.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    updateProfile({ commit }, formData) {
      return new Promise((resolve, reject) => {
        const token = localStorage.getItem("token");

        Api.defaults.headers.common["Authorization"] = `Bearer ${token}`;

        Api.post("/profile", formData)
          .then((response) => {
            commit("SET_PROFILE", response.data.data);

            resolve(response);
          })
          .catch((error) => {
            reject(error.response.data);
          });
      });
    },

    updatePassword({ commit }, user) {
      return new Promise((resolve, reject) => {
        const token = localStorage.getItem("token");

        Api.defaults.headers.common["Authorization"] = `Bearer ${token}`;

        Api.post("/profile/password", {
          password: user.password,
          password_confirmation: user.password_confirmation,
        })
          .then((response) => {
            commit("SET_PROFILE", response.data.data);

            resolve(response);
          })
          .catch((error) => {
            reject(error.response.data);
          });
      });
    },
  },

  //getters
  getters: {},
};

export default profile;
