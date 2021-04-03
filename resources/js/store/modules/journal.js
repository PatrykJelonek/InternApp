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
        },

        CONFIRM_JOURNAL_ENTRIES(state, data) {
            state.journalEntries.forEach((journalEntry) => {
               data.forEach((id) => {
                  if(journalEntry.id === id)
                      journalEntry.accepted = 1;
               });
            });
        },
    },

    actions: {
        createJournalEntries({commit}, data) {
            return axios.post('/api/journals', data);
        },

        confirmMany({commit}, ids) {
            return axios.post('/api/journals/confirmMany', {array: ids});
        },

        confirmJournalEntries({commit}, data) {
            commit('CONFIRM_JOURNAL_ENTRIES', data);
        },

        async fetchJournalEntries({commit}, {agreementId, studentId}) {
            try {
                let response = await axios.get(`/api/internships/${agreementId}/students/${studentId}/journal-entries`);
                commit('SET_JOURNAL_ENTRIES', response.data);
            } catch(e) {
                commit('SET_JOURNAL_ENTRIES', []);
                console.error(
                    `Błąd pobrania danych z endpoint'u /api/internships/{agreement}/students/{student}/journal-entries`,
                    {agreementId: agreementId, studentId: studentId, dump: e})
            }
        },
    },
}
