export default {
    namespaced: true,

    state: {
        createInternshipDialog: false,
        createOfferDialog: false,
        fillHeight: false,
    },

    getters: {
        createInternshipDialog(state) {
            return state.createInternshipDialog;
        },

        createOfferDialog(state) {
            return state.createOfferDialog;
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

        TOGGLE_CREATE_OFFER_DIALOG(state, value) {
            state.createInternshipDialog = value;
        },

        SET_FILL_HEIGHT(state, value) {
            state.fillHeight = value;
        }
    },

    actions: {
        toggleCreateInternshipDialog({commit}, value) {
            commit('TOGGLE_CREATE_INTERNSHIP_DIALOG', value);
        },

        toggleCreateDialog({commit}, value) {
            commit('TOGGLE_CREATE_OFFER_DIALOG', value);
        },

        setFillHeight({commit}, value) {
            commit('SET_FILL_HEIGHT', value);
        }
    },
}
