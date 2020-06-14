export default {
    namespaced: true,

    state: {
        //states
    },

    getters: {
        //Getters
    },

    mutations: {
        //Mutations
    },

    actions: {
        createAgreement({commit}, agreement) {
            return axios.post('/api/agreements', agreement);
        },
    },
}
