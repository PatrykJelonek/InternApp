export default {
    namespaced: true,

    state: {
        internships: [],
    },

    getters: {
        internships(state) {
            return state.internships;
        }
    },

    mutations: {
        SET_INTERNSHIPS(state, data) {
            state.internships = data;
        }
    },

    actions: {
        async fetchInternships({commit}) {
            try {
                let response = await axios.get('/api/internships');
                commit('SET_INTERNSHIPS', response.data.data);
            } catch(e) {
                commit('SET_INTERNSHIPS', []);
            }
        },

        apply({commit}, data) {
            return axios.post(`/api/internships`, data);
        },

        confirm({commit}, id) {
            return axios.get(`/api/internships/${id}/confirm`);
        }
    },
}
