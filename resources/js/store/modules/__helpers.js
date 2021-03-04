export default {
    namespaced: true,

    state: {
        dialog: false,
    },

    getters: {
        dialog(state) {
            return state.dialog;
        }
    },

    mutations: {
        TOGGLE_DIALOG(state) {
            state.dialog = !state.dialog;
        },
    },

    actions: {
        toggleDialog({commit}) {
            commit('TOGGLE_DIALOG');
        }
    },
}
