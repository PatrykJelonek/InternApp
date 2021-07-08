export default {
    namespaced: true,

    state: {
        faculties: [],
        facultiesLoading: false,
    },

    getters: {
        faculties(state) {
            return state.faculties;
        },

        facultiesLoading(state) {
            return state.facultiesLoading;
        }
    },

    mutations: {
        SET_FACULTIES(state, data) {
            state.faculties = data;
        },

        SET_FACULTIES_LOADING(state, data) {
            state.facultiesLoading = data;
        }
    },

    actions: {
        async fetchFaculties({commit}) {
            commit('SET_FACULTIES_LOADING', true);
            try {
                let response = await axios.get('/api/faculties');
                commit('SET_FACULTIES', response.data);
                commit('SET_FACULTIES_LOADING', false);
            } catch(e) {
                commit('SET_FACULTIES', []);
                commit('SET_FACULTIES_LOADING', false);
            }
        },

        async fetchFacultiesByUniversityId({commit}, id) {
            commit('SET_FACULTIES_LOADING', true);
            try {
                let response = await axios.get(`/api/university/${id}/faculties`);
                commit('SET_FACULTIES', response.data.data);
                commit('SET_FACULTIES_LOADING', false);
            } catch(e) {
                commit('SET_FACULTIES', []);
                commit('SET_FACULTIES_LOADING', false);
            }
        }
    },
}
