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
        }
    },

    getters: {
        dialog(state) {
            return state.dialog;
        }
    },

    mutations: {
        TOGGLE_DIALOG(state, name) {
            state.dialog[name].value = !state.dialog[name].value;
        },
    },

    actions: {
        toggleDialog({commit}, name) {
            commit('TOGGLE_DIALOG', name);
        }
    },
}
