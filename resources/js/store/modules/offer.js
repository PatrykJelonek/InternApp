export default {
    namespaced: true,

    state: {
        offer: '',
        offers: [],
        offerCategories: [],
        offerCategoriesLoading: true,
    },

    getters: {
        offer: state => {
            return state.offer;
        },

        offers: state => {
            return state.offers;
        },

        offerCategories: state => {
            return state.offerCategories;
        },

        offerCategoriesLoading: state => {
            return state.offerCategoriesLoading;
        },
    },

    mutations: {
        SET_OFFER_CATEGORIES(state, data) {
            state.offerCategories = data;
        },

        SET_OFFER_CATEGORIES_LOADING(state, data) {
            state.offerCategoriesLoading = data;
        },

        SET_OFFERS(state, data) {
            state.offers = data;
        },

        SET_OFFER(state, data) {
            state.offer = data;
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

        async fetchOffer({commit}, id) {
            try{
                let response = await axios.get(`/api/offers/${id}`);
                commit('SET_OFFER', response.data.data);
            } catch (e) {
                commit('SET_OFFER', '');
            }
        },

        async fetchOfferCategories({commit}) {
            commit('SET_OFFER_CATEGORIES_LOADING', true);
            try{
                let response = await axios.get('/api/offers/categories');
                commit('SET_OFFER_CATEGORIES', response.data.data);
                commit('SET_OFFER_CATEGORIES_LOADING', false);
            } catch (e) {
                commit('SET_OFFER_CATEGORIES', []);
                commit('SET_OFFER_CATEGORIES_LOADING', false);
            }
        },

        createOffer({commit}, offer) {
            return axios.post('/api/offers', offer);
        },
    },
}
