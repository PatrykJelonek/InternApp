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
        createOwnAgreementDialog: false,
        fillHeight: false,
        navigationDrawer: false,
        errorMessage: '',
        selectedCompany: null,
        selectedUniversity: null,
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

        createOwnAgreementDialog(state) {
            return state.createOwnAgreementDialog;
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
        },

        navigationDrawer(state) {
            return state.navigationDrawer;
        },

        selectedCompany(state) {
            return state.selectedCompany;
        },

        selectedUniversity(state) {
            return state.selectedUniversity;
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

        TOGGLE_CREATE_OWN_AGREEMENT_DIALOG(state, value) {
            state.createOwnAgreementDialog = value;
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
        },

        TOGGLE_NAVIGATION_DRAWER(state, value) {
            state.navigationDrawer = value;
        },

        SET_SELECTED_UNIVERSITY(state, data) {
            state.selectedUniversity = data;
        },

        SET_SELECTED_COMPANY(state, data) {
            state.selectedCompany = data;
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

        toggleCreateOwnAgreementDialog({commit}, value) {
            commit('TOGGLE_CREATE_OWN_AGREEMENT_DIALOG', value);
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

        toggleNavigationDrawer({commit}, value) {
            commit('TOGGLE_NAVIGATION_DRAWER', value);
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
        },

        setSelectedCompany({commit}, value) {
            commit('SET_SELECTED_COMPANY', value);
        },

        setSelectedUniversity({commit}, value) {
            commit('SET_SELECTED_UNIVERSITY', value);
        },
    },
}
