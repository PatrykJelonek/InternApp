import Vue from 'vue';

export default {
    namespaced: true,

    state: {
        universities: [],
        universityTypes: [],
    },

    getters: {
        getAllUniversities: state => {
            return state.universities;
        },

        universityTypes: (state) => {
            return state.universityTypes;
        }
    },

    mutations: {
        SET_UNIVERSITIES(state, data) {
            state.universities = data;
        },

        SET_UNIVERSITY_TYPES(state, data) {
            state.universityTypes = data;
        },
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
        }
    }
};
