export default {
    namespaced: true,

    state: {
        numberOfOffers: 0,
        numberOfOffersLoading: true,
        numberOfAgreements: 0,
        numberOfAgreementsLoading: true,
        numberOfUsers: 0,
        numberOfUsersLoading: true,
        numberOfCompanies: 0,
        numberOfCompaniesLoading: true,
        numberOfUniversities: 0,
        numberOfUniversitiesLoading: true,
        numberOfAttachments: 0,
        numberOfAttachmentsLoading: true,
        numberOfOffersAttachments: 0,
        numberOfOffersAttachmentsLoading: true,
    },

    getters: {
        numberOfOffers(state) {
            return state.numberOfOffers;
        },

        numberOfOffersLoading(state) {
            return state.numberOfOffersLoading;
        },

        numberOfAgreements(state) {
            return state.numberOfAgreements;
        },

        numberOfAgreementsLoading(state) {
            return state.numberOfAgreementsLoading;
        },

        numberOfUsers(state) {
            return state.numberOfUsers;
        },

        numberOfUsersLoading(state) {
            return state.numberOfUsersLoading;
        },

        numberOfCompanies(state) {
            return state.numberOfCompanies;
        },

        numberOfCompaniesLoading(state) {
            return state.numberOfCompaniesLoading;
        },

        numberOfUniversities(state) {
            return state.numberOfUniversities;
        },

        numberOfUniversitiesLoading(state) {
            return state.numberOfUniversitiesLoading;
        },

        numberOfAttachments(state) {
            return state.numberOfAttachments;
        },

        numberOfAttachmentsLoading(state) {
            return state.numberOfAttachmentsLoading;
        },

        numberOfOffersAttachments(state) {
            return state.numberOfOffersAttachments;
        },

        numberOfOffersAttachmentsLoading(state) {
            return state.numberOfOffersAttachmentsLoading;
        },
    },

    mutations: {
        SET_NUMBER_OF_OFFERS(state, data) {
            state.numberOfOffers = data;
        },

        SET_NUMBER_OF_OFFERS_LOADING(state, data) {
            state.numberOfOffersLoading = data;
        },

        SET_NUMBER_OF_AGREEMENTS(state, data) {
            state.numberOfAgreements = data;
        },

        SET_NUMBER_OF_AGREEMENTS_LOADING(state, data) {
            state.numberOfAgreementsLoading = data;
        },

        SET_NUMBER_OF_USERS(state, data) {
            state.numberOfUsers = data;
        },

        SET_NUMBER_OF_USERS_LOADING(state, data) {
            state.numberOfUsersLoading = data;
        },

        SET_NUMBER_OF_COMPANIES(state, data) {
            state.numberOfCompanies = data;
        },

        SET_NUMBER_OF_COMPANIES_LOADING(state, data) {
            state.numberOfCompaniesLoading = data;
        },

        SET_NUMBER_OF_UNIVERSITIES(state, data) {
            state.numberOfUniversities = data;
        },

        SET_NUMBER_OF_UNIVERSITIES_LOADING(state, data) {
            state.numberOfUniversitiesLoading = data;
        },

        SET_NUMBER_OF_ATTACHMENTS(state, data) {
            state.numberOfAttachments = data;
        },

        SET_NUMBER_OF_ATTACHMENTS_LOADING(state, data) {
            state.numberOfAttachmentsLoading = data;
        },

        SET_NUMBER_OF_OFFERS_ATTACHMENTS(state, data) {
            state.numberOfOffersAttachments = data;
        },

        SET_NUMBER_OF_OFFERS_ATTACHMENTS_LOADING(state, data) {
            state.numberOfOffersAttachmentsLoading = data;
        },
    },

    actions: {
        async fetchNumberOfOffers({commit}) {
            commit('SET_NUMBER_OF_OFFERS_LOADING', true);
            try {
                let response = await axios.get(`/api/statistics/offers/count`);
                commit('SET_NUMBER_OF_OFFERS', response.data);
                commit('SET_NUMBER_OF_OFFERS_LOADING', false);
            } catch (e) {
                commit('SET_NUMBER_OF_OFFERS', 0);
                commit('SET_NUMBER_OF_OFFERS_LOADING', false);
            }
        },

        async fetchNumberOfAgreements({commit}) {
            commit('SET_NUMBER_OF_AGREEMENTS_LOADING', true);
            try {
                let response = await axios.get(`/api/statistics/agreements/count`);
                commit('SET_NUMBER_OF_AGREEMENTS', response.data);
                commit('SET_NUMBER_OF_AGREEMENTS_LOADING', false);
            } catch (e) {
                commit('SET_NUMBER_OF_AGREEMENTS', 0);
                commit('SET_NUMBER_OF_AGREEMENTS_LOADING', false);
            }
        },

        async fetchNumberOfUsers({commit}) {
            commit('SET_NUMBER_OF_USERS_LOADING', true);
            try {
                let response = await axios.get(`/api/statistics/users/count`);
                commit('SET_NUMBER_OF_USERS', response.data);
                commit('SET_NUMBER_OF_USERS_LOADING', false);
            } catch (e) {
                commit('SET_NUMBER_OF_USERS', 0);
                commit('SET_NUMBER_OF_USERS_LOADING', false);
            }
        },

        async fetchNumberOfCompanies({commit}) {
            commit('SET_NUMBER_OF_COMPANIES_LOADING', true);
            try {
                let response = await axios.get(`/api/statistics/companies/count`);
                commit('SET_NUMBER_OF_COMPANIES', response.data);
                commit('SET_NUMBER_OF_COMPANIES_LOADING', false);
            } catch (e) {
                commit('SET_NUMBER_OF_COMPANIES', 0);
                commit('SET_NUMBER_OF_COMPANIES_LOADING', false);
            }
        },

        async fetchNumberOfUniversities({commit}) {
            commit('SET_NUMBER_OF_UNIVERSITIES_LOADING', true);
            try {
                let response = await axios.get(`/api/statistics/universities/count`);
                commit('SET_NUMBER_OF_UNIVERSITIES', response.data);
                commit('SET_NUMBER_OF_UNIVERSITIES_LOADING', false);
            } catch (e) {
                commit('SET_NUMBER_OF_UNIVERSITIES', 0);
                commit('SET_NUMBER_OF_UNIVERSITIES_LOADING', false);
            }
        },

        async fetchNumberOfAttachments({commit}) {
            commit('SET_NUMBER_OF_ATTACHMENTS_LOADING', true);
            try {
                let response = await axios.get(`/api/statistics/attachments/count`);
                commit('SET_NUMBER_OF_ATTACHMENTS', response.data);
                commit('SET_NUMBER_OF_ATTACHMENTS_LOADING', false);
            } catch (e) {
                commit('SET_NUMBER_OF_ATTACHMENTS', 0);
                commit('SET_NUMBER_OF_ATTACHMENTS_LOADING', false);
            }
        },

        async fetchNumberOfOffersAttachments({commit}) {
            commit('SET_NUMBER_OF_OFFERS_ATTACHMENTS_LOADING', true);
            try {
                let response = await axios.get(`/api/statistics/offers/attachments/count`);
                commit('SET_NUMBER_OF_OFFERS_ATTACHMENTS', response.data);
                commit('SET_NUMBER_OF_OFFERS_ATTACHMENTS_LOADING', false);
            } catch (e) {
                commit('SET_NUMBER_OF_OFFERS_ATTACHMENTS', 0);
                commit('SET_NUMBER_OF_OFFERS_ATTACHMENTS_LOADING', false);
            }
        },
    },
}
