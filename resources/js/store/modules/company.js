export default {
    namespaced: true,

    state: {
        companyCategories: [],
    },

    getters: {
        companyCategories(state) {
            return state.companyCategories;
        }
    },

    mutations: {
        SET_COMPANY_CATEGORIES(state, data) {
            state.companyCategories = data;
        }
    },

    actions: {
        async fetchCompanyCategories({commit}) {
            try {
                let response = await axios.get('/api/company-categories')
                commit('SET_COMPANY_CATEGORIES', response.data.data);
            } catch (e) {
                commit('SET_COMPANY_CATEGORIES', []);
            }
        },

        createCompany({commit}, company) {
            return axios.post('/api/companies', company);
        }
    },
}
