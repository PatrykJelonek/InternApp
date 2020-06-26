export default {
    namespaced: true,

    state: {
        journalEntries: [],
    },

    getters: {
        journalsEntries(state) {
            return state.journalEntries;
        }
    },

    mutations: {
        SET_JOURNAL_ENTRIES(state, data) {
            state.journalEntries = data;
        }
    },

    actions: {
        createJournalEntries({commit}, data) {
            return axios.post('/api/journals', data);
        }
    },
}
