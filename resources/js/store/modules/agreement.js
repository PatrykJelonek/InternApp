export default {
    namespaced: true,

    state: {
        agreement: ''
    },

    getters: {
        agreement(state) {
            return state.agreement;
        }
    },

    mutations: {
        SET_AGREEMENT(state, data) {
            state.agreement = data;
        }
    },

    actions: {
        async fetchAgreement({commit}, id) {
            try {
                let response = await axios.get(`/api/agreements/${id}`);
                commit('SET_AGREEMENT', response.data.data);
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
