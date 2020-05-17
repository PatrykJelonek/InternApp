import Vue from 'vue';

export default {
    state: {
        universities: []
    },
    getters: {
        getAllUniversities: state => {
            return state.universities;
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
        }
    },
    mutations: {
        SET_UNIVERSITIES(state, data) {
            state.universities = data;
        },
    }
};
