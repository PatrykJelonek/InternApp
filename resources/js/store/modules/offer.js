export default {
    namespaced: true,

    state: {
        offer: '',
        offerLoading: true,
        offers: [],
        offersLoading: true,
        offerCategories: [],
        offerCategoriesLoading: false,
        offerStatuses: [],
        offerStatusesLoading: false,
    },

    getters: {
        offer: state => {
            return state.offer;
        },

        offerLoading: state => {
            return state.offerLoading;
        },

        offers: state => {
            return state.offers;
        },

        offersLoading: state => {
            return state.offersLoading;
        },

        offerCategories: state => {
            return state.offerCategories;
        },

        offerCategoriesLoading: state => {
            return state.offerCategoriesLoading;
        },

        offerStatuses: state => {
            return state.offerStatuses;
        },

        offerStatusesLoading: state => {
            return state.offerStatusesLoading;
        },
    },

    mutations: {
        SET_OFFER_CATEGORIES(state, data) {
            state.offerCategories = data;
        },

        SET_OFFER_CATEGORIES_LOADING(state, data) {
            state.offerCategoriesLoading = data;
        },

        SET_OFFER_STATUSES(state, data) {
            state.offerStatuses = data;
        },

        SET_OFFER_STATUSES_LOADING(state, data) {
            state.offerStatusesLoading = data;
        },

        SET_OFFERS(state, data) {
            state.offers = data;
        },

        SET_OFFERS_LOADING(state, data) {
            state.offersLoading = data;
        },

        SET_OFFER(state, data) {
            state.offer = data;
        },

        SET_OFFER_LOADING(state, data) {
            state.offerLoading = data;
        },

        SET_OFFER_STATUS(state, data) {
            state.offers.forEach((offer) => {
                if(offer.id === data.id) {
                    offer.status = data.status;
                }
            })
        },
    },

    actions: {
        async fetchOffers({commit}, data = null) {
            commit('SET_OFFERS_LOADING', true);
            try{
                let response = await axios.get('/api/offers', {
                    params: {
                        categories: data.categories ?? null,
                        statuses: data.statuses ?? null,
                        onlyWithPlaces: data.onlyWithPlaces ?? null,
                        limit: data.limit ?? null,
                    }
                });
                commit('SET_OFFERS', response.data);
                commit('SET_OFFERS_LOADING', false);
            } catch (e) {
                commit('SET_OFFERS', []);
                commit('SET_OFFERS_LOADING', false);
            }
        },

        async fetchOffer({commit}, slug) {
            commit('SET_OFFER_LOADING', true);
            try{
                let response = await axios.get(`/api/offers/${slug}`);
                commit('SET_OFFER', response.data);
                commit('SET_OFFER_LOADING', false);
            } catch (e) {
                commit('SET_OFFER', '');
                commit('SET_OFFER_LOADING', false);
            }
        },

        async fetchOfferCategories({commit}) {
            commit('SET_OFFER_CATEGORIES_LOADING', true);
            try{
                let response = await axios.get('/api/offers/categories');
                commit('SET_OFFER_CATEGORIES', response.data);
                commit('SET_OFFER_CATEGORIES_LOADING', false);
            } catch (e) {
                commit('SET_OFFER_CATEGORIES', []);
                commit('SET_OFFER_CATEGORIES_LOADING', false);
            }
        },

        async fetchOfferStatuses({commit}) {
            commit('SET_OFFER_STATUSES_LOADING', true);
            try{
                let response = await axios.get('/api/offers/statuses');
                commit('SET_OFFER_STATUSES', response.data);
                commit('SET_OFFER_STATUSES_LOADING', false);
            } catch (e) {
                commit('SET_OFFER_STATUSES', []);
                commit('SET_OFFER_STATUSES_LOADING', false);
            }
        },

        createOffer({commit}, offer) {
            return axios.post('/api/offers', offer, {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            });
        },

        async acceptOffer({commit}, slug) {
            try{
                let response = await axios.get(`/api/offers/${slug}/accept`);
                commit('SET_OFFER_STATUS', response.data);
            } catch (e) {

            }
        },

        async rejectOffer({commit}, slug) {
            try{
                let response = await axios.get(`/api/offers/${slug}/reject`);
                commit('SET_OFFER_STATUS', response.data);
            } catch (e) {

            }
        },
    },
}
