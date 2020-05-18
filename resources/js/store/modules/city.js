export default {
    namespaced: true,

    state: {
        cities: [],
    },

    getters: {
        cities: (state) => {
            return state.cities;
        }
    },

    mutations: {
        SET_CITIES(state, data) {
            state.cities = data;
        }
    },

    actions: {
        async fetchCities({commit}) {
            try {
                let response = await axios.get('/api/cities');
                commit('SET_CITIES', response.data.data);
            } catch(e) {
                commit('SET_CITIES', []);
            }
        }
    }
}
