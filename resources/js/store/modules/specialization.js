export default {
    namespaced: true,

    state: {
        specializations: [],
    },

    getters: {
        specializations(state) {
            return state.specializations;
        }
    },

    mutations: {
        SET_SPECIALIZATIONS(state, data) {
            state.specializations = data;
        }
    },

    actions: {
        async fetchSpecializations({commit}) {
            try {
                let response = await axios.get('/api/specializations');
                commit('SET_SPECIALIZATIONS', response.data.data);
            } catch(e) {
                commit('SET_SPECIALIZATIONS', []);
            }
        },

        async fetchSpecializationsByFieldId({commit}, id) {
            try {
                let response = await axios.get(`/api/field/${id}/specializations`);
                commit('SET_SPECIALIZATIONS', response.data.data);
            } catch(e) {
                commit('SET_SPECIALIZATIONS', []);
            }
        }
    },
}
