export default {
    namespaced: true,

    state: {
        internships: [],
        internship: null,
        internshipStudents: [],
        preview: null,
        internshipLoading: true,
        internshipStudentsLoading: true,
        internshipStatuses: [],
        internshipStatusesLoading: false,
    },

    getters: {
        internships(state) {
            return state.internships;
        },

        internship(state) {
            return state.internship;
        },

        internshipStudents(state) {
            return state.internshipStudents;
        },

        preview(state) {
            return state.preview;
        },

        internshipLoading(state) {
            return state.internshipLoading;
        },

        internshipStudentsLoading(state) {
            return state.internshipStudentsLoading;
        },

        internshipStatuses(state) {
            return state.internshipStatuses;
        },

        internshipStatusesLoading(state) {
            return state.internshipStatusesLoading;
        },
    },

    mutations: {
        SET_INTERNSHIPS(state, data) {
            state.internships = data;
        },

        SET_INTERNSHIP(state, data) {
            state.internship = data;
        },

        SET_INTERNSHIP_STUDENTS(state, data) {
            state.internshipStudents = data;
        },

        SET_PREVIEW(state, data) {
            state.preview = data;
        },

        SET_INTERNSHIP_LOADING(state, data) {
            state.internshipLoading = data;
        },

        SET_INTERNSHIP_STUDENTS_LOADING(state, data) {
            state.internshipStudentsLoading = data;
        },

        SET_INTERNSHIP_STATUSES(state, data) {
            state.internshipStatuses = data;
        },

        SET_INTERNSHIP_STATUSES_LOADING(state, data) {
            state.internshipStatusesLoading = data;
        },
    },

    actions: {
        async fetchInternships({commit}) {
            try {
                let response = await axios.get('/api/internships');
                commit('SET_INTERNSHIPS', response.data.data);
            } catch (e) {
                commit('SET_INTERNSHIPS', []);
            }
        },

        async fetchInternship({commit}, id) {
            commit('SET_INTERNSHIP_LOADING', true);
            try {
                let response = await axios.get(`/api/internships/${id}`);
                commit('SET_INTERNSHIP', response.data);
                commit('SET_INTERNSHIP_LOADING', false);
            } catch (e) {
                commit('SET_INTERNSHIP_LOADING', false);
                commit('SET_INTERNSHIP', []);
            }
        },

        async fetchInternshipStudents({commit}, id) {
            commit('SET_INTERNSHIP_STUDENTS_LOADING', true);
            try {
                let response = await axios.get(`/api/internships/${id}/students`);
                commit('SET_INTERNSHIP_STUDENTS', response.data);
                commit('SET_INTERNSHIP_STUDENTS_LOADING', false);
            } catch (e) {
                commit('SET_INTERNSHIP_STUDENTS', []);
                commit('SET_INTERNSHIP_STUDENTS_LOADING', false);
            }
        },

        async fetchInternshipStatuses({commit}) {
            commit('SET_INTERNSHIP_STATUSES_LOADING', true);
            try {
                let response = await axios.get(`/api/internships/statuses`);
                commit('SET_INTERNSHIP_STATUSES', response.data);
                commit('SET_INTERNSHIP_STATUSES_LOADING', false);
            } catch (e) {
                commit('SET_INTERNSHIP_STATUSES', []);
                commit('SET_INTERNSHIP_STATUSES_LOADING', false);
            }
        },

        apply({commit}, data) {
            return axios.post(`/api/internships`, data);
        },

        create({commit}, data) {
            return axios.post(`/api/internships`, data);
        },

        confirm({commit}, id) {
            return axios.get(`/api/internships/${id}/confirm`);
        },

        setPreview({commit}, data) {
            commit('SET_PREVIEW', data);
        },

        createTask({commit}, {internshipId, studentIndex, task}) {
            return axios.post(`/api/internships/${internshipId}/students/${studentIndex}/tasks`, task);
        },

        changeInternshipStatus({commit}, {internshipId, statusId}) {
            return axios.put(`/api/internships/${internshipId}/change-status`, {
                statusId: statusId,
            })
        },

        downloadInternshipJournal({commit}, {internship, student}) {
            return axios.get(`/api/internships/${internship}/students/${student}/download`);
        }
    },
}
