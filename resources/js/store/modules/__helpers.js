export default {
    namespaced: true,

    state: {
        dialog: {
            TASK_DIALOG: {
                value: false,
            },
            JOURNAL_ENTRY_DIALOG: {
                value: false,
            }
        },

        createInternshipDialog: false,
    },

    getters: {
        dialog(state) {
            return state.dialog;
        },

        createInternshipDialog(state) {
            return state.createInternshipDialog;
        }
    },

    mutations: {
        TOGGLE_DIALOG(state, name) {
            state.dialog[name].value = !state.dialog[name].value;
        },

        TOGGLE_CREATE_INTERNSHIP_DIALOG(state, value) {
            if(value.length > 0) {
                state.createInternshipDialog = value;
            } else {
                state.createInternshipDialog = !state.createInternshipDialog;
            }
        }
    },

    actions: {
        toggleDialog({commit}, name) {
            commit('TOGGLE_DIALOG', name);
        },

        toggleCreateInternshipDialog({commit}, value) {
            commit('TOGGLE_CREATE_INTERNSHIP_DIALOG', value);
        }
    },
}
