export default {
    namespaced: true,

    state: {
        newOffers: [],
    },

    getters: {
        newOffers(state) {
            return state.newOffers;
        }
    },

    mutations: {
        SET_NEW_OFFERS(state, data) {
            state.newOffers = data;
        }
    },

    actions: {
        async fetchNewOffers({commit}, id) {
            try {
                let response = await axios.get(`/api/agreements/${id}`);
                commit('SET_AGREEMENT', response.data.data);
            } catch(e) {
                commit('SET_AGREEMENT', null);
            }
        },
    },
}
