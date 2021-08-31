const SELECTED_COMPANY_LOCAL_STORAGE_KEY = 'SELECTED_COMPANY';
const SELECTED_UNIVERSITY_LOCAL_STORAGE_KEY = 'SELECTED_UNIVERSITY';

export default {
    namespaced: true,

    state: {
        dialogs: {
            DIALOG_FIELD_ACTIVATE_AGREEMENT: false,
            DIALOG_FIELD_DEACTIVATE_AGREEMENT: false,
            DIALOG_FIELD_DELETE_AGREEMENT: false,
            DIALOG_FIELD_CHANGE_INTERNSHIP_STATUS: false,
            DIALOG_FIELD_SELECT_ROLES: false,
            DIALOG_FIELD_VERIFY_UNIVERSITY_WORKER: false,
            DIALOG_FIELD_GENERATE_STUDENT_JOURNAL: false,
            DIALOG_FIELD_INTERNSHIP_SUMMARY: false,
            DIALOG_FIELD_RATE_STUDENT: false,
            DIALOG_FIELD_SELECT_TYPE_OF_UNIVERSITY_USER: false,
            DIALOG_FIELD_CONFIRM_JOINING_TO_COMPANY: false,
            DIALOG_FIELD_CREATE_OWN_AGREEMENT: false,
            DIALOG_FIELD_CREATE_AGREEMENT_FROM_OFFER: false,
            DIALOG_FIELD_VERIFY_UNIVERSITY: false,
            DIALOG_FIELD_CONFIRM_INTERNSHIP_APPLICATION: false,
            DIALOG_FIELD_CREATE_JOURNAL_ENTRY_COMMENT: false,
            DIALOG_FIELD_CONFIRM_DELETE_JOURNAL_ENTRY: false,
            DIALOG_FIELD_CONFIRM_UPDATE_JOURNAL_ENTRIES: false,
            DIALOG_FIELD_CONFIRM_DELETE_JOURNAL_ENTRIES_COMMENT: false,
        },
        dialogsArgs: {
            DIALOG_FIELD_ACTIVATE_AGREEMENT: null,
            DIALOG_FIELD_DEACTIVATE_AGREEMENT: null,
            DIALOG_FIELD_DELETE_AGREEMENT: null,
            DIALOG_FIELD_CHANGE_INTERNSHIP_STATUS: null,
            DIALOG_FIELD_SELECT_ROLES: null,
            DIALOG_FIELD_VERIFY_UNIVERSITY_WORKER: null,
            DIALOG_FIELD_GENERATE_STUDENT_JOURNAL: null,
            DIALOG_FIELD_INTERNSHIP_SUMMARY: null,
            DIALOG_FIELD_RATE_STUDENT: null,
            DIALOG_FIELD_SELECT_TYPE_OF_UNIVERSITY_USER: null,
            DIALOG_FIELD_CONFIRM_JOINING_TO_COMPANY: null,
            DIALOG_FIELD_CREATE_OWN_AGREEMENT: null,
            DIALOG_FIELD_CREATE_AGREEMENT_FROM_OFFER: null,
            DIALOG_FIELD_VERIFY_UNIVERSITY: null,
            DIALOG_FIELD_CONFIRM_INTERNSHIP_APPLICATION: null,
            DIALOG_FIELD_CREATE_JOURNAL_ENTRY_COMMENT: null,
            DIALOG_FIELD_CONFIRM_DELETE_JOURNAL_ENTRY: null,
            DIALOG_FIELD_CONFIRM_UPDATE_JOURNAL_ENTRIES: null,
            DIALOG_FIELD_CONFIRM_DELETE_JOURNAL_ENTRIES_COMMENT: null,
        },
        createInternshipDialog: false,
        createOfferDialog: false,
        acceptOfferDialog: false,
        rejectOfferDialog: false,
        createAgreementDialog: false,
        acceptAgreementDialog: false,
        rejectAgreementDialog: false,
        applyInternshipDialog: false,
        createOwnAgreementDialog: false,
        createQuestionnaireDialog: false,
        deleteCompanyWorkerDialog: false,
        acceptCompanyWorkerDialog: false,
        universityFacultyDialog: false,
        universityFieldDialog: false,
        universitySpecializationDialog: false,
        deleteUniversityFacultyDialog: false,
        universityFacultyDialogArgs: null,
        universityFieldDialogArgs: null,
        universitySpecializationDialogArgs: null,
        fillHeight: false,
        navigationDrawer: true,
        navigationDrawerModel: true,
        errorMessage: '',
        selectedCompany: null,
        selectedUniversity: null,
        breadcrumbs: [],
        createOwnAgreementStepper: 1,
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

        createQuestionnaireDialog(state) {
            return state.createQuestionnaireDialog;
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

        navigationDrawerModel(state) {
            return state.navigationDrawerModel;
        },

        selectedCompany(state) {
            return state.selectedCompany !== null ? state.selectedCompany : JSON.parse(localStorage.getItem(SELECTED_COMPANY_LOCAL_STORAGE_KEY));
        },

        selectedUniversity(state) {
            return state.selectedUniversity !== null ? state.selectedUniversity : JSON.parse(localStorage.getItem(SELECTED_UNIVERSITY_LOCAL_STORAGE_KEY));
        },

        breadcrumbs(state) {
            return state.breadcrumbs;
        },

        deleteCompanyWorkerDialog(state) {
            return state.deleteCompanyWorkerDialog;
        },

        acceptCompanyWorkerDialog(state) {
            return state.acceptCompanyWorkerDialog;
        },

        universityFacultyDialog(state) {
            return state.universityFacultyDialog;
        },

        universityFieldDialog(state) {
            return state.universityFieldDialog;
        },

        universitySpecializationDialog(state) {
            return state.universitySpecializationDialog;
        },

        universityFacultyDialogArgs(state) {
            return state.universityFacultyDialogArgs;
        },

        universityFieldDialogArgs(state) {
            return state.universityFieldDialogArgs;
        },

        universitySpecializationDialogArgs(state) {
            return state.universitySpecializationDialogArgs;
        },

        deleteUniversityFacultyDialog(state) {
            return state.deleteUniversityFacultyDialog;
        },

        dialogs(state) {
            return state.dialogs;
        },

        dialogsArgs(state) {
            return state.dialogsArgs;
        },

        createOwnAgreementStepper(state) {
            return state.createOwnAgreementStepper;
        },
    },

    mutations: {
        TOGGLE_CREATE_INTERNSHIP_DIALOG(state, value) {
            if (value.length > 0) {
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

        TOGGLE_CREATE_QUESTIONNAIRE_DIALOG(state, value) {
            state.createQuestionnaireDialog = value;
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
        },

        SET_BREADCRUMBS(state, data) {
            state.breadcrumbs = data;
        },

        TOGGLE_DELETE_COMPANY_WORKER_DIALOG(state, value) {
            state.deleteCompanyWorkerDialog = value;
        },

        TOGGLE_ACCEPT_COMPANY_WORKER_DIALOG(state, value) {
            state.acceptCompanyWorkerDialog = value;
        },

        TOGGLE_UNIVERSITY_FACULTY_DIALOG(state, value) {
            state.universityFacultyDialog = value;
        },

        TOGGLE_UNIVERSITY_FIELD_DIALOG(state, value) {
            state.universityFieldDialog = value;
        },

        TOGGLE_UNIVERSITY_SPECIALIZATION_DIALOG(state, value) {
            state.universitySpecializationDialog = value;
        },

        TOGGLE_DELETE_UNIVERSITY_FACULTY_DIALOG(state, value) {
            state.deleteUniversityFacultyDialog = value;
        },

        SET_UNIVERSITY_FACULTY_DIALOG_ARGS(state, value) {
            state.universityFacultyDialogArgs = value;
        },

        SET_UNIVERSITY_FIELD_DIALOG_ARGS(state, value) {
            state.universityFieldDialogArgs = value;
        },

        SET_UNIVERSITY_SPECIALIZATION_DIALOG_ARGS(state, value) {
            state.universitySpecializationDialogArgs = value;
        },

        CLEAR_UNIVERSITY_FACULTY_DIALOG_ARGS(state) {
            state.universityFacultyDialogArgs = null;
        },

        CLEAR_UNIVERSITY_FIELD_DIALOG_ARGS(state) {
            state.universityFieldDialogArgs = null;
        },

        CLEAR_UNIVERSITY_SPECIALIZATION_DIALOG_ARGS(state) {
            state.universitySpecializationDialogArgs = null;
        },

        TOGGLE_NAVIGATION_DRAWER_MODEL(state, value) {
            state.navigationDrawerModel = value;
        },

        TOGGLE_DIALOG(state, {key, val}) {
            state.dialogs[key] = val;
        },

        SET_DIALOG_ARGS(state, {key, val}) {
            state.dialogsArgs[key] = val;
        },

        SET_CREATE_OWN_AGREEMENT_STEPPER(state, val) {
            state.createOwnAgreementStepper = val;
        },
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

        toggleNavigationDrawerModel({commit}, value) {
            commit('TOGGLE_NAVIGATION_DRAWER_MODEL', value);
        },

        toggleCreateQuestionnaireDialog({commit}, value) {
            commit('TOGGLE_CREATE_QUESTIONNAIRE_DIALOG', value);
        },

        toggleDeleteCompanyWorkerDialog({commit}, value) {
            commit('TOGGLE_DELETE_COMPANY_WORKER_DIALOG', value);
        },

        toggleAcceptCompanyWorkerDialog({commit}, value) {
            commit('TOGGLE_ACCEPT_COMPANY_WORKER_DIALOG', value);
        },

        toggleUniversityFacultyDialog({commit}, value) {
            commit('TOGGLE_UNIVERSITY_FACULTY_DIALOG', value);
        },

        toggleUniversityFieldDialog({commit}, value) {
            commit('TOGGLE_UNIVERSITY_FIELD_DIALOG', value);
        },

        toggleUniversitySpecializationDialog({commit}, value) {
            commit('TOGGLE_UNIVERSITY_SPECIALIZATION_DIALOG', value);
        },

        toggleDeleteUniversityFacultyDialog({commit}, value) {
            commit('TOGGLE_DELETE_UNIVERSITY_FACULTY_DIALOG', value);
        },

        setUniversityFacultyDialogArgs({commit}, value) {
            commit('SET_UNIVERSITY_FACULTY_DIALOG_ARGS', value);
        },

        setUniversityFieldDialogArgs({commit}, value) {
            commit('SET_UNIVERSITY_FIELD_DIALOG_ARGS', value);
        },

        setUniversitySpecializationDialogArgs({commit}, value) {
            commit('SET_UNIVERSITY_SPECIALIZATION_DIALOG_ARGS', value);
        },

        clearUniversityFacultyDialogArgs({commit}) {
            commit('CLEAR_UNIVERSITY_FACULTY_DIALOG_ARGS');
        },

        clearUniversityFieldDialogArgs({commit}) {
            commit('CLEAR_UNIVERSITY_FIELD_DIALOG_ARGS');
        },

        clearUniversitySpecializationDialogArgs({commit}) {
            commit('CLEAR_UNIVERSITY_SPECIALIZATION_DIALOG_ARGS');
        },

        toggleDialog({commit}, {key, val}) {
            commit('TOGGLE_DIALOG', {key: key, val: val});
        },

        setDialogArgs({commit}, {key, val}) {
            commit('SET_DIALOG_ARGS', {key: key, val: val});
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
            localStorage.setItem(SELECTED_COMPANY_LOCAL_STORAGE_KEY, JSON.stringify(value));
            commit('SET_SELECTED_COMPANY', value);
        },

        setSelectedUniversity({commit}, value) {
            localStorage.setItem(SELECTED_UNIVERSITY_LOCAL_STORAGE_KEY, JSON.stringify(value));
            commit('SET_SELECTED_UNIVERSITY', value);
        },

        setBreadcrumbs({commit}, value) {
            commit('SET_BREADCRUMBS', value);
        },

        setCreateOwnAgreementStepper({commit}, value) {
            commit('SET_CREATE_OWN_AGREEMENT_STEPPER', value);
        }
    },
}
