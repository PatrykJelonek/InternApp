export default {
    namespaced: true,

    state: {
        snackbar: {
            message: false,
            text: null,
            color: null,
        }
    },

    getters: {
        snackbar(state) {
            return state.snackbar;
        }
    },

    mutations: {
        SET_SNACKBAR(state, {message, color}) {
            state.snackbar.message = message;
            state.snackbar.color = color;
            state.snackbar.show = true;
        },

        CLOSE_SNACKBAR(state) {
            state.snackbar.message = null;
            state.snackbar.color = null;
            state.snackbar.show = false;
        }
    },

    actions: {
        setSnackbar({commit}, settings) {
            commit('SET_SNACKBAR', settings);
        },

        closeSnackbar({commit}) {
            commit('CLOSE_SNACKBAR');
        }
    },
}
