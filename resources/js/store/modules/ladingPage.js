export default {
    namespaced: true,

    state: {
        offers: [],
        offersLoading: true,
    },

    getters: {
        offers(state) {
            return state.offers;
        },

        offersLoading(state) {
            return state.offersLoading;
        },
    },

    mutations: {
        SET_OFFERS(state, data) {
            state.offers = data;
        },

        SET_OFFERS_LOADING(state, data) {
            state.offersLoading = data;
        },
    },

    actions: {
        async fetchOffers({commit}) {
            commit('SET_OFFERS_LOADING', true);
            try{
                let response = await axios.get('/api/helpers/offers');
                commit('SET_OFFERS', response.data);
                commit('SET_OFFERS_LOADING', false);
            } catch (e) {
                commit('SET_OFFERS', []);
                commit('SET_OFFERS_LOADING', false);
            }
        },
    },
}
