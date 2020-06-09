export default {
    namespaced: true,

    state: {
        offers: [],
        offerCategories: []
    },

    getters: {
        offers: state => {
            return state.offers;
        },

        offerCategories: state => {
            return state.offerCategories;
        }
    },

    mutations: {
        SET_OFFER_CATEGORIES(state, data) {
            state.offerCategories = data;
        },

        SET_OFFERS(state, data) {
            state.offers = data;
        }
    },

    actions: {
        async fetchOffers({commit}) {
            try{
                let response = await axios.get('/api/offers');
                commit('SET_OFFERS', response.data.data);
            } catch (e) {
                commit('SET_OFFERS', []);
            }
        },

        async fetchOfferCategories({commit}) {
            try{
                let response = await axios.get('/api/offers/categories');
                commit('SET_OFFER_CATEGORIES', response.data.data);
            } catch (e) {
                commit('SET_OFFER_CATEGORIES', []);
            }
        },

        createOffer({commit}, offer) {
            return axios.post('/api/offers', offer);
        }
    },
}
