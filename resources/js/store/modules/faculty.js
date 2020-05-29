export default {
    namespaced: true,

    state: {
        faculties: [],
    },

    getters: {
        faculties(state) {
            return state.faculties;
        }
    },

    mutations: {
        SET_FACULTIES(state, data) {
            state.faculties = data;
        }
    },

    actions: {
        async fetchFaculties({commit}) {
            try {
                let response = await axios.get('/api/faculties');
                commit('SET_FACULTIES', response.data.data);
            } catch(e) {
                commit('SET_FACULTIES', []);
            }
        },

        async fetchFacultiesByUniversityId({commit}, id) {
            try {
                let response = await axios.get(`/api/university/${id}/faculties`);
                commit('SET_FACULTIES', response.data.data);
            } catch(e) {
                commit('SET_FACULTIES', []);
            }
        }
    },
}
