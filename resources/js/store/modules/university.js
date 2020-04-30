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
             return window.axios.get("/api/universities")
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
