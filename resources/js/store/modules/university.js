export default {
    namespaced: true,

    state: {
        selectedUniversityId: '',
        selectedUniversity: null,
        universities: [],
        universityTypes: [],
        universityUsers: [],
        universityAgreements: [],
        internships: [],
        students: [],
        studentsLoading: false,
        university: null,
        universityLoading: true,
        workers: [],
        workersLoading: true,
        agreements: [],
        agreementsLoading: true,
    },

    getters: {
        universities: state => {
            return state.universities;
        },

        university: state => {
            return state.university;
        },

        universityLoading: state => {
            return state.universityLoading;
        },

        universityTypes: (state) => {
            return state.universityTypes;
        },

        selectedUniversity: (state) => {
            return state.selectedUniversity;
        },

        universityUsers: (state) => {
            return state.universityUsers;
        },

        universityAgreements: (state) => {
            return state.universityAgreements;
        },

        internships: (state) => {
            return state.internships;
        },

        selectedUniversityId: (state) => {
            return state.selectedUniversityId;
        },

        students: (state) => {
            return state.students;
        },

        studentsLoading: (state) => {
            return state.studentsLoading;
        },

        workers: (state) => {
            return state.workers;
        },

        workersLoading: (state) => {
            return state.workersLoading;
        },

        agreements: (state) => {
            return state.agreements;
        },

        agreementsLoading: (state) => {
            return state.agreementsLoading;
        },
    },

    mutations: {
        SET_UNIVERSITIES(state, data) {
            state.universities = data;
        },

        SET_UNIVERSITY_TYPES(state, data) {
            state.universityTypes = data;
        },

        SET_SELECTED_UNIVERSITY(state, university) {
            state.selectedUniversity = university;
        },

        SET_CODE(state, accessCode) {
            state.selectedUniversity.access_code = accessCode;
        },

        SET_UNIVERSITY_USERS(state, data) {
            state.universityUsers = data;
        },

        SET_UNIVERSITY_AGREEMENTS(state, data) {
            state.universityAgreements = data;
        },

        SET_INTERNSHIPS(state, data) {
            state.internships = data;
        },

        SET_SELECTED_UNIVERSITY_ID(state, data) {
            state.selectedUniversityId = data;
        },

        SET_STUDENTS(state, data) {
            state.students = data;
        },

        SET_STUDENTS_LOADING(state, data) {
            state.studentsLoading = data;
        },

        SET_UNIVERSITY(state, data) {
            state.university = data;
        },

        SET_UNIVERSITY_LOADING(state, data) {
            state.universityLoading = data;
        },

        SET_WORKERS(state, data) {
            state.workers = data;
        },

        SET_WORKERS_LOADING(state, data) {
            state.workersLoading = data;
        },

        SET_AGREEMENTS(state, data) {
            state.agreements = data;
        },

        SET_AGREEMENTS_LOADING(state, data) {
            state.agreementsLoading = data;
        },
    },

    actions: {
        async fetchUniversities({commit}) {
             try {
                 let response = await axios.get('/api/universities');
                 commit('SET_UNIVERSITIES', response.data.data);
             } catch(e) {
                 commit('SET_UNIVERSITIES', []);
             }
        },

        async fetchUniversityTypes({commit}) {
            try {
                let response = await axios.get('/api/university-types');
                commit('SET_UNIVERSITY_TYPES', response.data.data);
            } catch (e) {
                commit('SET_UNIVERSITY_TYPES', []);
            }
        },

        async fetchUniversityUsers({commit}, id) {
            try {
                let response = await axios.get(`/api/universities/${id}/users`);
                commit('SET_UNIVERSITY_USERS', response.data.data);
            } catch (e) {
                commit('SET_UNIVERSITY_USERS', []);
            }
        },

        async fetchUniversityAgreements({commit}, id) {
            try {
                let response = await axios.get(`/api/universities/${id}/agreements`);
                commit('SET_UNIVERSITY_AGREEMENTS', response.data.data);
            } catch (e) {
                commit('SET_UNIVERSITY_AGREEMENTS', []);
            }
        },

        async fetchInternships({commit}, id) {
            try {
                let response = await axios.get(`/api/universities/${id}/internships`);
                commit('SET_INTERNSHIPS', response.data.data);
            } catch (e) {
                commit('SET_INTERNSHIPS', []);
            }
        },

        createUniversity({commit}, university) {
            return axios.post('/api/universities', university);
        },

        selectUniversity({commit}, university) {
            commit('SET_SELECTED_UNIVERSITY', university);
        },

        selectUniversityId({commit}, id) {
            commit('SET_SELECTED_UNIVERSITY_ID', id);
        },

        async generateCode({commit}, id) {
            try {
                let response = await axios.post('/api/university/generate-code', {
                    id: id
                });
                commit('SET_CODE', response.data.data);
            } catch (e) {
                commit('SET_CODE', e.response.data.message);
            }
        },

        useCode({commit}, accessCode) {
            return axios.post('/api/university/use-code', {
                accessCode: accessCode
            });
        },

        async fetchStudents({commit}, slug) {
            commit('SET_STUDENTS_LOADING', true);
            try {
                let response = await axios.get(`/api/universities/${slug}/students`);
                commit('SET_STUDENTS', response.data);
                commit('SET_STUDENTS_LOADING', false);
            } catch (e) {
                commit('SET_STUDENTS', []);
                commit('SET_STUDENTS_LOADING', false);
            }
        },

        async fetchWorkers({commit}, slug) {
            commit('SET_WORKERS_LOADING', true);
            try {
                let response = await axios.get(`/api/universities/${slug}/workers`);
                commit('SET_WORKERS', response.data);
                commit('SET_WORKERS_LOADING', false);
            } catch (e) {
                commit('SET_WORKERS', []);
                commit('SET_WORKERS_LOADING', false);
            }
        },

        async fetchAgreements({commit}, slug) {
            commit('SET_AGREEMENTS_LOADING', true);
            try {
                let response = await axios.get(`/api/universities/${slug}/agreements`);
                commit('SET_AGREEMENTS', response.data);
                commit('SET_AGREEMENTS_LOADING', false);
            } catch (e) {
                commit('SET_AGREEMENTS', []);
                commit('SET_AGREEMENTS_LOADING', false);
            }
        },

        async fetchUniversity({commit}, slug) {
            commit('SET_UNIVERSITY_LOADING', true);
            try {
                let response = await axios.get(`/api/universities/${slug}`);
                commit('SET_UNIVERSITY', response.data);
                commit('SET_UNIVERSITY_LOADING', false);
            } catch (e) {
                commit('SET_UNIVERSITY', []);
                commit('SET_UNIVERSITY_LOADING', false);
            }
        }
    }
};
