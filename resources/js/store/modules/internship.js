export default {
    namespaced: true,

    state: {
        internships: [],
        internship: null,
    },

    getters: {
        internships(state) {
            return state.internships;
        },

        internship(state) {
            return state.internship;
        }
    },

    mutations: {
        SET_INTERNSHIPS(state, data) {
            state.internships = data;
        },

        SET_INTERNSHIP(state, data) {
            state.internship = data;
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

        async fetchInternship({commit}, id) {
            try {
                let response = await axios.get(`/api/internships/${id}`);
                commit('SET_INTERNSHIP', response.data.data);
            } catch(e) {
                commit('SET_INTERNSHIP', []);
            }
        },

        apply({commit}, data) {
            return axios.post(`/api/internships`, data);
        },

        confirm({commit}, id) {
            return axios.get(`/api/internships/${id}/confirm`);
        },
    },
}
