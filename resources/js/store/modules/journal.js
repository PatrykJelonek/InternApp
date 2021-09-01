export default {
    namespaced: true,

    state: {
        journalEntries: [],
        journalEntryComments: [],
        journalEntryCommentsLoading: false,
    },

    getters: {
        journalsEntries(state) {
            return state.journalEntries;
        },

        journalEntryComments(state) {
            return state.journalEntryComments;
        },

        journalEntryCommentsLoading(state) {
            return state.journalEntryCommentsLoading;
        },
    },

    mutations: {
        SET_JOURNAL_ENTRIES(state, data) {
            state.journalEntries = data;
        },

        SET_JOURNAL_ENTRY_COMMENTS(state, data) {
            state.journalEntryComments = data;
        },

        SET_JOURNAL_ENTRY_COMMENTS_LOADING(state, data) {
            state.journalEntryCommentsLoading = data;
        },

        CONFIRM_JOURNAL_ENTRIES(state, data) {
            state.journalEntries.forEach((journalEntry) => {
                data.forEach((id) => {
                    if (journalEntry.id === id)
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
            } catch (e) {
                commit('SET_JOURNAL_ENTRIES', []);
                console.error(
                    `Błąd pobrania danych z endpoint'u /api/internships/{agreement}/students/{student}/journal-entries`,
                    {agreementId: agreementId, studentId: studentId, dump: e})
            }
        },

        async fetchJournalEntryComments({commit}, {internshipId, studentIndex, studentJournalEntryId}) {
            commit('SET_JOURNAL_ENTRY_COMMENTS_LOADING', true);
            try {
                let response = await axios.get(`/api/internships/${internshipId}/students/${studentIndex}/journal-entries/${studentJournalEntryId}/comments`);
                commit('SET_JOURNAL_ENTRY_COMMENTS', response.data);
                commit('SET_JOURNAL_ENTRY_COMMENTS_LOADING', false);
            } catch (e) {
                commit('SET_JOURNAL_ENTRIES', []);
                commit('SET_JOURNAL_ENTRY_COMMENTS_LOADING', false);
            }
        },

        createStudentJournalEntryComment({commit}, {internshipId, studentIndex, studentJournalEntryId, content}) {
            return axios.post(`/api/internships/${internshipId}/students/${studentIndex}/journal-entries/${studentJournalEntryId}/comments`, {
                content: content,
            })
        },

        deleteStudentJournalEntry({commit}, {internshipId, studentIndex, studentJournalEntryId}) {
            return axios.delete(`/api/internships/${internshipId}/students/${studentIndex}/journal-entries/${studentJournalEntryId}`);
        },

        deleteStudentJournalEntryComment({commit}, {internshipId, studentIndex, studentJournalEntryId, commentId}) {
            return axios.delete(`/api/internships/${internshipId}/students/${studentIndex}/journal-entries/${studentJournalEntryId}/comments/${commentId}`);
        },

        updateStudentJournalEntry({commit}, {internshipId, studentIndex, studentJournalEntryId, content}) {
            return axios.put(`/api/internships/${internshipId}/students/${studentIndex}/journal-entries/${studentJournalEntryId}`, {
                content: content
            });
        },

        acceptStudentJournalEntry({commit}, {internshipId, studentIndex, studentJournalEntryId}) {
            return axios.put(`/api/internships/${internshipId}/students/${studentIndex}/journal-entries/${studentJournalEntryId}/accept`);
        }
    },
}
