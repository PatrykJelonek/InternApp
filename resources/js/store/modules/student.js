export default {
    namespaced: true,

    state: {
        student: '',
        students: [],
        studentJournalEntries: [],
    },

    getters: {
        student(state) {
            return state.student;
        },

        students(state) {
            return state.students;
        },

        studentJournalEntries(state) {
            return state.studentJournalEntries;
        }
    },

    mutations: {
        SET_STUDENT(state, data) {
            state.student = data;
        },

        SET_STUDENTS(state, data) {
            state.students = data;
        },

        SET_STUDENT_JOURNAL_ENTRIES(state, data) {
            state.studentJournalEntries = data;
        }
    },

    actions: {
        createStudent({commit}, data) {
            return axios.post('/api/students', data);
        },

        async fetchStudentJournalEntries({commit}, {internshipId, studentIndex}) {
            try {
                let response = await axios.get(`/api/internships/${internshipId}/students/${studentIndex}/journal-entries`);
                commit('SET_STUDENT_JOURNAL_ENTRIES', response.data);
            } catch (e) {
                console.error(e);
            }
        }
    },
}
