export default {
    namespaced: true,

    state: {
        fields: [],
    },

    getters: {
        fields(state) {
            return state.fields;
        }
    },

    mutations: {
        SET_FIELDS(state, data) {
            state.fields = data;
        }
    },

    actions: {
        async fetchFieldsByFacultyId({commit}, id) {
            try {
                let response = await axios.get(`/api/faculty/${id}/fields`);
                commit('SET_FIELDS', response.data.data);
            } catch (e) {
                commit('SET_FIELDS', []);
            }
        }
    },
}
