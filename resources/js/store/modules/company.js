export default {
    namespaced: true,

    state: {
        company: '',
        selectedCompany: null,
        selectedCompanyId: null,
        companyCategories: [],
        companyUsers: [],
        companyOffers: [],
        companyAgreements: [],
        interns: [],
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
        },

        companyOffers(state) {
            return state.companyOffers;
        },

        companyAgreements(state) {
            return state.companyAgreements;
        },

        selectedCompanyId(state) {
            return state.selectedCompanyId;
        },

        interns(state) {
            return state.interns;
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
        },

        SET_COMPANY_OFFERS(state, data) {
            state.companyOffers = data;
        },

        SET_COMPANY_AGREEMENTS(state, data) {
            state.companyAgreements = data;
        },

        SET_SELECTED_COMPANY_ID(state, data) {
            state.selectedCompanyId = data;
        },

        SET_INTERNS(state, data) {
            state.interns = data;
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

        async fetchCompanyOffers({commit}, id) {
            try {
                let response = await axios.get(`/api/companies/${id}/offers`);
                commit('SET_COMPANY_OFFERS', response.data.data);
            } catch(e) {
                commit('SET_COMPANY_OFFERS', []);
            }
        },

        async fetchCompanyAgreements({commit}, id) {
            try {
                let response = await axios.get(`/api/companies/${id}/agreements`);
                commit('SET_COMPANY_AGREEMENTS', response.data.data);
            } catch(e) {
                commit('SET_COMPANY_AGREEMENTS', []);
            }
        },

        async fetchInterns({commit}, id) {
            try {
                let response = await axios.get(`/api/companies/${id}/interns`);
                commit('SET_INTERNS', response.data.data);
            } catch(e) {
                commit('SET_INTERNS', []);
            }
        },

        createCompany({commit}, company) {
            return axios.post('/api/companies', company);
        },

        selectCompany({commit}, company) {
            commit('SELECT_COMPANY', company);
        },

        selectCompanyId({commit}, id) {
            commit('SET_SELECTED_COMPANY_ID', id);
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
