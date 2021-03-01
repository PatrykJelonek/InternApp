export default {
    namespaced: true,

    state: {
        internships: [],
        internship: null,
        internshipStudents: [],
        preview: null,
        internshipLoading: true,
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
            return state.internshipLoading
        }
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
    },

    actions: {
        async fetchInternships({commit}) {
            try {
                let response = await axios.get('/api/internships');
                commit('SET_INTERNSHIPS', response.data.data);
            } catch(e) {
                commit('SET_INTERNSHIPS', []);
            }
        },

        async fetchInternship({commit}, id) {
            commit('SET_INTERNSHIP_LOADING', true);

            try {
                let response = await axios.get(`/api/internships/${id}`);
                commit('SET_INTERNSHIP', response.data);
                commit('SET_INTERNSHIP_LOADING', false);
            } catch(e) {
                commit('SET_INTERNSHIP', []);
            }
        },

        async fetchInternshipStudents({commit}, id) {
            try {
                let response = await axios.get(`/api/internships/${id}/students`);
                commit('SET_INTERNSHIP_STUDENTS', response.data);
            } catch(e) {
                commit('SET_INTERNSHIP_STUDENTS', []);
            }
        },

        apply({commit}, data) {
            return axios.post(`/api/internships`, data);
        },

        confirm({commit}, id) {
            return axios.get(`/api/internships/${id}/confirm`);
        },

        setPreview({commit}, data) {
            commit('SET_PREVIEW', data);
        }
    },
}
