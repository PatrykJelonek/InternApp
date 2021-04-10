export default {
    namespaced: true,

    state: {
        student: '',
        students: [],
        studentJournalEntries: [],
        loadingStudentJournalEntries: true,
        studentTasks: [],
        loadingStudentTasks: true,
        availableStudentOffers: [],
        availableStudentOffersLoading: true,
        internshipApplications: [],
        internshipApplicationsLoading: true,
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
        },

        internshipApplications(state) {
            return state.internshipApplications;
        },

        internshipApplicationsLoading(state) {
            return state.internshipApplicationsLoading;
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
            state.studentJournalEntries.sort((a, b) => {
                if (a.date > b.date) return -1;
                if (a.date <= b.date) return 1;
            })
        },

        SET_INTERNSHIP_APPLICATIONS(state, data) {
            state.internshipApplications = data;
        },

        SET_INTERNSHIP_APPLICATIONS_LOADING(state, data) {
            state.internshipApplicationsLoading = data;
        }
    },

    actions: {
        createStudent({commit}, data) {
            return axios.post('/api/students', data);
        },

        async fetchStudentJournalEntries({commit}, {internshipId, studentIndex}) {
            if (internshipId && studentIndex) {
                commit('SET_LOADING_STUDENT_JOURNAL_ENTRIES', true);
                try {
                    let response = await axios.get(`/api/internships/${internshipId}/students/${studentIndex}/journal-entries`);
                    commit('SET_STUDENT_JOURNAL_ENTRIES', response.data);
                    commit('SET_LOADING_STUDENT_JOURNAL_ENTRIES', false);
                } catch (e) {
                    console.error(e);
                    commit('SET_LOADING_STUDENT_JOURNAL_ENTRIES', false);
                }
            } else {
                commit('SET_LOADING_STUDENT_JOURNAL_ENTRIES', false);
            }
        },

        async fetchStudentTasks({commit}, {internshipId, studentIndex}) {
            if (internshipId && studentIndex) {
                commit('SET_LOADING_STUDENT_TASKS', true);
                try {
                    let response = await axios.get(`/api/internships/${internshipId}/students/${studentIndex}/tasks`);
                    commit('SET_STUDENT_TASKS', response.data);
                    commit('SET_LOADING_STUDENT_TASKS', false);
                } catch (e) {
                    console.error(e);
                    commit('SET_LOADING_STUDENT_TASKS', false);
                }
            } else {
                commit('SET_LOADING_STUDENT_TASKS', false);
            }
        },

        async fetchStudentInternshipApplications({commit}, {studentId}) {
            try {
                let response = await axios.get(`/api/students/${studentId}/internship-applications`);
                commit('SET_INTERNSHIP_APPLICATIONS_LOADING', false);
                commit('SET_INTERNSHIP_APPLICATIONS', response.data);
            } catch (e) {
                commit('SET_INTERNSHIP_APPLICATIONS_LOADING', false);
            }
        },

        createStudentJournalEntry({commit}, {internshipId, studentIndex, journalEntry}) {
            return axios.post(`/api/internships/${internshipId}/students/${studentIndex}/journal-entries`, journalEntry);
        },

        addStudentJournalEntry({commit}, data) {
            commit('PUSH_STUDENT_JOURNAL_ENTRY', data);
        }
    },
}
