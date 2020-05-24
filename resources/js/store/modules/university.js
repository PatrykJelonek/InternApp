import Vue from 'vue';

export default {
    namespaced: true,

    state: {
        selectedUniversity: null,
        universities: [],
        universityTypes: [],
    },

    getters: {
        getAllUniversities: state => {
            return state.universities;
        },

        universityTypes: (state) => {
            return state.universityTypes;
        },

        selectedUniversity: (state) => {
            return state.selectedUniversity;
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
        }
    },

    actions: {
        async fetchUniversitiesFromApi({commit}) {
             return window.axios({
                 method: 'get',
                 url: '/api/universities',
                 headers: { 'X-CSRF-TOKEN': window.Laravel.csrfToken},
             }).then(res => {
                 console.log(res.data);
                    commit("SET_UNIVERSITIES", res.data.data);
                })
                .catch(error => {
                    console.log(error);
                });
        },

        async fetchUniversityTypes({commit}) {
            try {
                let response = await axios.get('/api/university-types');
                commit('SET_UNIVERSITY_TYPES', response.data.data);
            } catch (e) {
                commit('SET_UNIVERSITY_TYPES', []);
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
