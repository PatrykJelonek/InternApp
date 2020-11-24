export default {
    namespaced: true,

    state: {
        activeTab: null,
    },

    getters: {
        activeTab: state =>  state.activeTab,
    },

    mutations: {
        SET_ACTIVE_TAB(state, tab)  {
            state.activeTab = tab;
        }
    },

    actions: {
        setActiveTab({commit}, tab) {
            commit('SET_ACTIVE_TAB', tab);
        }
    }
}
