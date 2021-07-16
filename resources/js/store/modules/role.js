export default {
    namespaced: true,

    state: {
        roles: null,
        rolesLoading: false,
    },

    getters: {
        roles(state) {
            return state.roles;
        },

        rolesLoading(state) {
            return state.rolesLoading;
        }
    },

    mutations: {
        SET_ROLES(state, data) {
            state.roles = data;
        },

        SET_ROLES_LOADING(state, data) {
            state.rolesLoading = data;
        },
    },

    actions: {
        async fetchRolesByGroups({commit}, groups) {
            commit('SET_ROLES_LOADING', true);
            try{
                let response = await axios.get('/api/roles', {
                    params: {
                        groups: groups
                    }
                });
                commit('SET_ROLES', response.data);
                commit('SET_ROLES_LOADING', false);
            } catch (e) {
                commit('SET_ROLES', []);
                commit('SET_ROLES_LOADING', false);
            }
        }
    },
}
