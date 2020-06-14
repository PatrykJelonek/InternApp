import Vue from 'vue';

export default {
    namespaced: true,

    state: {
        selectedUniversity: null,
        universities: [],
        universityTypes: [],
        universityUsers: [],
        universityAgreements: [],
    },

    getters: {
        universities: state => {
            return state.universities;
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
        }
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
        }
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
                let response = await axios.get(`api/universities/${id}/agreements`);
                commit('SET_UNIVERSITY_AGREEMENTS', response.data.data);
            } catch (e) {
                commit('SET_UNIVERSITY_AGREEMENTS', []);
            }
        },

        createUniversity({commit}, university) {
            return axios.post('/api/universities', university);
        },

        selectUniversity({commit}, university) {
            commit('SET_SELECTED_UNIVERSITY', university);
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
        }
    }
};
