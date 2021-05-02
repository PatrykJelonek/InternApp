export default {
    namespaced: true,

    state: {
        createInternshipDialog: false,
        createOfferDialog: false,
        acceptOfferDialog: false,
        rejectOfferDialog: false,
        createAgreementDialog: false,
        acceptAgreementDialog: false,
        rejectAgreementDialog: false,
        applyInternshipDialog: false,
        fillHeight: false,
        errorMessage: '',
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

        createAgreementDialog(state) {
            return state.createAgreementDialog;
        },

        acceptAgreementDialog(state) {
            return state.acceptAgreementDialog;
        },

        rejectAgreementDialog(state) {
            return state.rejectAgreementDialog;
        },

        applyInternshipDialog(state) {
            return state.applyInternshipDialog;
        },

        errorMessage(state) {
            return state.errorMessage;
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

        TOGGLE_CREATE_AGREEMENT_DIALOG(state, value) {
            state.createAgreementDialog = value;
        },

        TOGGLE_ACCEPT_AGREEMENT_DIALOG(state, value) {
            state.acceptAgreementDialog = value;
        },

        TOGGLE_REJECT_AGREEMENT_DIALOG(state, value) {
            state.rejectAgreementDialog = value;
        },

        TOGGLE_APPLY_INTERNSHIP_DIALOG(state, value) {
            state.applyInternshipDialog = value;
        },

        SET_ERROR_MESSAGE(state, value) {
            state.errorMessage = value;
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

        toggleCreateAgreementDialog({commit}, value) {
            commit('TOGGLE_CREATE_AGREEMENT_DIALOG', value);
        },

        toggleAcceptAgreementDialog({commit}, value) {
            commit('TOGGLE_ACCEPT_AGREEMENT_DIALOG', value);
        },

        toggleRejectAgreementDialog({commit}, value) {
            commit('TOGGLE_REJECT_AGREEMENT_DIALOG', value);
        },

        toggleApplyInternshipDialog({commit}, value) {
            commit('TOGGLE_APPLY_INTERNSHIP_DIALOG', value);
        },

        parseErrorMessage({commit}, status) {
            switch (status) {
                case 404:
                    commit('SET_ERROR_MESSAGE', 'Nie znaleziono zasobu');
                    break;
                case 403:
                    commit('SET_ERROR_MESSAGE', 'Nie masz uprawnień');
                    break;
                default:
                    commit('SET_ERROR_MESSAGE', 'Nieznany błąd');
                    break;
            }
        },

        setFillHeight({commit}, value) {
            commit('SET_FILL_HEIGHT', value);
        }
    },
}
