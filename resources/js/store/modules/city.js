export default {
    namespaced: true,

    state: {
        cities: [],
        city: null,
        cityLoading: false,
    },

    getters: {
        cities: (state) => {
            return state.cities;
        },

        city(state) {
            return state.city;
        },

        cityLoading(state) {
            return state.cityLoading;
        },
    },

    mutations: {
        SET_CITIES(state, data) {
            state.cities = data;
        },

        SET_CITY(state, data) {
            state.city = data;
        },

        SET_CITY_LOADING(state, data) {
            state.cityLoading = data;
        },
    },

    actions: {
        async fetchCities({commit}) {
            try {
                let response = await axios.get('/api/cities');
                commit('SET_CITIES', response.data.data);
            } catch (e) {
                commit('SET_CITIES', []);
            }
        },

        async fetchCity({commit}, postcode) {
            commit('SET_CITY_LOADING', true);
            try {
                let response = await axios.get(`/api/cities/${postcode}`);
                commit('SET_CITY', response.data);
                commit('SET_CITY_LOADING', false);
            } catch (e) {
                commit('SET_CITY', '');
                commit('SET_CITY_LOADING', false);
            }
        }
    }
}
