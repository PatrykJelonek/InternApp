export default {
    namespaced: true,

    state: {
        company: '',
        selectedCompany: null,
        selectedCompanyId: null,
        companyCategories: [],
        companyCategoriesLoading: true,
        companyUsers: [],
        companyOffers: [],
        companyAgreements: [],
        companies: [],
        companiesLoading: [],
        interns: [],
    },

    getters: {
        companyCategories(state) {
            return state.companyCategories;
        },

        companyCategoriesLoading(state) {
            return state.companyCategoriesLoading;
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
        },

        companies(state) {
            return state.companies;
        },

        companiesLoading(state) {
            return state.companiesLoading;
        }
    },

    mutations: {
        SET_COMPANY_CATEGORIES(state, data) {
            state.companyCategories = data;
        },

        SET_COMPANY_CATEGORIES_LOADING(state, data) {
            state.companyCategoriesLoading = data;
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
        },

        SET_COMPANIES(state, data) {
            state.companies = data;
        },

        SET_COMPANIES_LOADING(state, data) {
            state.companiesLoading = data;
        }
    },

    actions: {
        async fetchCompanyCategories({commit}) {
            commit('SET_COMPANY_CATEGORIES_LOADING', true);
            try {
                let response = await axios.get('/api/companies/categories')
                commit('SET_COMPANY_CATEGORIES', response.data);
                commit('SET_COMPANY_CATEGORIES_LOADING', false);
            } catch (e) {
                commit('SET_COMPANY_CATEGORIES', []);
                commit('SET_COMPANY_CATEGORIES_LOADING', false);
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

        async fetchCompanies({commit}) {
            commit('SET_COMPANIES_LOADING', true);
            try {
                let response = await axios.get(`/api/companies`);
                commit('SET_COMPANIES', response.data);
                commit('SET_COMPANIES_LOADING', false);
            } catch(e) {
                commit('SET_COMPANIES', []);
                commit('SET_COMPANIES_LOADING', false);
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
