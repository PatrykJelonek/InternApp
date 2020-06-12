export default {
    namespaced: true,

    state: {
        company: '',
        selectedCompany: null,
        companyCategories: [],
        companyUsers: []
    },

    getters: {
        companyCategories(state) {
            return state.companyCategories;
        },

        selectedCompany(state) {
            return state.selectedCompany;
        },

        companyUsers(state) {
            return state.companyUsers;
        },

        company(state) {
            return state.company;
        }
    },

    mutations: {
        SET_COMPANY_CATEGORIES(state, data) {
            state.companyCategories = data;
        },

        SET_COMPANY_USERS(state, data) {
            state.companyUsers = data;
        },

        SET_COMPANY(state, data) {
            state.company = data;
        },

        SELECT_COMPANY(state, company) {
            state.selectedCompany = company;
        },

        SET_CODE(state, code) {
            state.selectedCompany.access_code = code;
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

        async fetchCompanyUsers({commit}, id) {
            try {
                let response = await axios.get(`/api/company/${id}/users`);
                commit('SET_COMPANY_USERS', response.data.data);
            } catch (e) {
                commit('SET_COMPANY_USERS', []);
            }
        },

        async fetchCompany({commit}, id) {
            try {
                let response = await axios.get(`/api/companies/${id}`);
                commit('SET_COMPANY', response.data.data);
            } catch(e) {
                commit('SET_COMPANY', '');
            }
        },

        createCompany({commit}, company) {
            return axios.post('/api/companies', company);
        },

        selectCompany({commit}, company) {
            commit('SELECT_COMPANY', company);
        },

        async generateCode({commit}, id) {
            try {
                let response = await axios.post('/api/company/generate-code', {
                    id: id
                });
                commit('SET_CODE', response.data.data);
            } catch (e) {
                commit('SET_CODE', e.response.data.message);
            }
        },

        useCode({commit}, code) {
            return axios.post('/api/company/use-code', {
                accessCode: code
            });
        }
    },
}
