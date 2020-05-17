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
                 headers: {
                     'X-CSRF-TOKEN': window.Laravel.csrfToken,
                     'Authorization': `${JSON.parse(localStorage.getItem('user')).token_type} ${JSON.parse(localStorage.getItem('user')).token}`
                 },
             })
                 .then(res => {
                    commit("SET_UNIVERSITIES", res.data);
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
