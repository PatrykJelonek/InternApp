export default {
    namespaced: true,

    state: {
        createInternshipDialog: false,
        createOfferDialog: false,
        acceptOfferDialog: false,
        rejectOfferDialog: false,
        fillHeight: false,
    },

    getters: {
        createInternshipDialog(state) {
            return state.createInternshipDialog;
        },

        createOfferDialog(state) {
            return state.createOfferDialog;
        },

        acceptOfferDialog(state) {
            return state.acceptOfferDialog;
        },

        rejectOfferDialog(state) {
            return state.rejectOfferDialog;
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
            state.createOfferDialog = value;
        },

        TOGGLE_ACCEPT_OFFER_DIALOG(state, value) {
            state.acceptOfferDialog = value;
        },

        TOGGLE_REJECT_OFFER_DIALOG(state, value) {
            state.rejectOfferDialog = value;
        },

        SET_FILL_HEIGHT(state, value) {
            state.fillHeight = value;
        }
    },

    actions: {
        toggleCreateInternshipDialog({commit}, value) {
            commit('TOGGLE_CREATE_INTERNSHIP_DIALOG', value);
        },

        toggleCreateOfferDialog({commit}, value) {
            commit('TOGGLE_CREATE_OFFER_DIALOG', value);
        },

        toggleAcceptOfferDialog({commit}, value) {
            commit('TOGGLE_ACCEPT_OFFER_DIALOG', value);
        },

        toggleRejectOfferDialog({commit}, value) {
            commit('TOGGLE_REJECT_OFFER_DIALOG', value);
        },

        setFillHeight({commit}, value) {
            commit('SET_FILL_HEIGHT', value);
        }
    },
}
