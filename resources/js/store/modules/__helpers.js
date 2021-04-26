export default {
    namespaced: true,

    state: {
        createInternshipDialog: false,
        fillHeight: false,
    },

    getters: {
        createInternshipDialog(state) {
            return state.createInternshipDialog;
        },

        fillHeight(state) {
            return state.fillHeight;
        }
    },

    mutations: {
        TOGGLE_CREATE_INTERNSHIP_DIALOG(state, value) {
            if(value.length > 0) {
                state.createInternshipDialog = value;
            } else {
                state.createInternshipDialog = !state.createInternshipDialog;
            }
        },

        SET_FILL_HEIGHT(state, value) {
            state.fillHeight = value;
        }
    },

    actions: {
        toggleCreateInternshipDialog({commit}, value) {
            commit('TOGGLE_CREATE_INTERNSHIP_DIALOG', value);
        },

        setFillHeight({commit}, value) {
            commit('SET_FILL_HEIGHT', value);
        }
    },
}
