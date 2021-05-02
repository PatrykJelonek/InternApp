export default {
    namespaced: true,

    state: {
        agreement: null,
        agreementLoading: true,
    },

    getters: {
        agreement(state) {
            return state.agreement;
        },

        agreementLoading(state) {
            return state.agreementLoading;
        }
    },

    mutations: {
        SET_AGREEMENT(state, data) {
            state.agreement = data;
        },

        SET_AGREEMENT_LOADING(state, data) {
            state.agreementLoading = data;
        }
    },

    actions: {
        async fetchAgreement({commit}, slug) {
            commit('SET_AGREEMENT_LOADING', true);
            try {
                let response = await axios.get(`/api/agreements/${slug}`);
                commit('SET_AGREEMENT', response.data);
                commit('SET_AGREEMENT_LOADING', false);
            } catch(e) {
                commit('SET_AGREEMENT', null);
                commit('SET_AGREEMENT_LOADING', false);
            }
        },

        async acceptAgreement({commit}, slug) {
            try {
                let response = await axios.get(`/api/agreements/${slug}/accept`);
                commit('SET_AGREEMENT', response.data);
            } catch(e) {
                commit('SET_AGREEMENT', null);
            }
        },

        async rejectAgreement({commit}, slug) {
            try {
                let response = await axios.get(`/api/agreements/${slug}/reject`);
                commit('SET_AGREEMENT', response.data);
            } catch(e) {
                commit('SET_AGREEMENT', null);
            }
        },

        createAgreement({commit}, agreement) {
            return axios.post('/api/agreements', agreement);
        },

        activeAgreement({commit}, id) {
            return axios.post(`/api/agreements/${id}/active`);
        }
    },
}
