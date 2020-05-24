export default {
    namespaced: true,

    state: {
        show: false,
        message: '',
        color: ''
    },

    getters: {
        message(state) {
            return state.message;
        },

        color(state) {
            return state.color;
        }
    },

    mutations: {
        SET_MESSAGE(state, {message, color}) {
            state.message = message;
            state.color = color;
            state.show = true;
        }
    },

    actions: {
        setSnackbar({commit}, settings) {
            commit('SET_MESSAGE', settings);
        }
    },
}
