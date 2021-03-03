export default {
    namespaced: true,

    state: {
        snackbarShow: false,
        snackbarMessage: '',
        snackbarColor: ''
    },

    getters: {
        getSnackbar(state) {
            return {
                snackbarShow: state.snackbarShow,
                snackbarMessage: state.snackbarMessage,
                snackbarColor: state.snackbarColor
            }
        }
    },

    mutations: {
        SET_SNACKBAR(state, {message, color}) {
            state.snackbarMessage = message;
            state.snackbarColor = color;
            state.snackbarShow = true;
        },

        CLOSE_SNACKBAR(state) {
            state.snackbarShow = false;
            state.snackbarMessage = '';
            state.snackbarColor = '';
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
