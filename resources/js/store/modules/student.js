export default {
    namespaced: true,

    state: {
        student: '',
        students: [],
        studentJournalEntries: [],
        loadingStudentJournalEntries: true,
        studentTasks: [],
        loadingStudentTasks: true,
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
        },

        loadingStudentJournalEntries(state) {
            return state.loadingStudentJournalEntries;
        },

        studentTasks(state) {
            return state.studentTasks;
        },

        loadingStudentTasks(state) {
            return state.loadingStudentTasks;
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
        },

        SET_LOADING_STUDENT_JOURNAL_ENTRIES(state, data) {
            state.loadingStudentJournalEntries = data;
        },

        SET_STUDENT_TASKS(state, data) {
            state.studentTasks = data;
        },

        SET_LOADING_STUDENT_TASKS(state, data) {
            state.loadingStudentTasks = data;
        },

        PUSH_STUDENT_JOURNAL_ENTRY(state, data) {
            state.studentJournalEntries.push(data);
        }
    },

    actions: {
        createStudent({commit}, data) {
            return axios.post('/api/students', data);
        },

        async fetchStudentJournalEntries({commit}, {internshipId, studentIndex}) {
            commit('SET_LOADING_STUDENT_JOURNAL_ENTRIES', true);

            try {
                let response = await axios.get(`/api/internships/${internshipId}/students/${studentIndex}/journal-entries`);
                commit('SET_STUDENT_JOURNAL_ENTRIES', response.data);
            } catch (e) {
                console.error(e);
            }

            commit('SET_LOADING_STUDENT_JOURNAL_ENTRIES', false);
        },

        async fetchStudentTasks({commit}, {internshipId, studentIndex}) {
            commit('SET_LOADING_STUDENT_TASKS', true);

            try {
                let response = await axios.get(`/api/internships/${internshipId}/students/${studentIndex}/tasks`);
                commit('SET_STUDENT_TASKS', response.data);
            } catch (e) {
                console.error(e);
            }

            commit('SET_LOADING_STUDENT_TASKS', false);
        },



        createStudentJournalEntry({commit}, {internshipId, studentIndex, journalEntry}) {
            return axios.post(`/api/internships/${internshipId}/students/${studentIndex}/journal-entries`, journalEntry);
        },
    },
}
