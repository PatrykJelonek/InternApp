export default {
    namespaced: true,

    state: {
        internships: [],
        internship: null,
        internshipStudents: [],
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
        }
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
            try {
                let response = await axios.get(`/api/internships/${id}`);
                commit('SET_INTERNSHIP', response.data);
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
    },
}
