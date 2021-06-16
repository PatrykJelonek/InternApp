export default {
    namespaced: true,

    state: {
        items: [],
    },

    getters: {
        items: state => state.items,
    },

    mutations: {
        SET_ITEMS(state, data) {
            state.items = data;
        }
    },

    actions: {
        setItems({commit}, items) {
            commit('SET_ITEMS', items);
        }
    }
}
