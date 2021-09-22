export default {
    namespaced: true,

    state: {
        company: null,
        companyLoading: false,
        selectedCompany: null,
        selectedCompanyId: null,
        companyCategories: [],
        companyCategoriesLoading: false,
        companyUsers: [],
        companyOffers: [],
        companyOffersLoading: false,
        companyAgreements: [],
        companyAgreementsLoading: false,
        companyWorkers: [],
        companyWorkersLoading: false,
        companies: [],
        companiesLoading: false,
        companiesToVerification: [],
        companiesToVerificationLoading: false,
        verifiedCompanies: [],
        verifiedCompaniesLoading: false,
        interns: [],
        codeLoading: false,
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

        codeLoading(state) {
            return state.codeLoading;
        },

        companyLoading(state) {
            return state.companyLoading;
        },

        companyOffers(state) {
            return state.companyOffers;
        },

        companyOffersLoading(state) {
            return state.companyOffersLoading;
        },

        companyAgreements(state) {
            return state.companyAgreements;
        },

        companyAgreementsLoading(state) {
            return state.companyAgreementsLoading;
        },

        companyWorkers(state) {
            return state.companyWorkers;
        },

        companyWorkersLoading(state) {
            return state.companyWorkersLoading;
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
        },

        companiesToVerification(state) {
            return state.companiesToVerification;
        },

        companiesToVerificationLoading(state) {
            return state.companiesToVerificationLoading;
        },

        verifiedCompanies(state) {
            return state.verifiedCompanies;
        },

        verifiedCompaniesLoading(state) {
            return state.verifiedCompaniesLoading;
        },
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

        SET_COMPANY_LOADING(state, data) {
            state.companyLoading = data;
        },

        SELECT_COMPANY(state, company) {
            state.selectedCompany = company;
        },

        SET_CODE(state, code) {
            state.company.access_code = code;
        },

        SET_COMPANY_OFFERS(state, data) {
            state.companyOffers = data;
        },

        SET_COMPANY_OFFERS_LOADING(state, data) {
            state.companyOffersLoading = data;
        },

        UNSHIFT_COMPANY_OFFER(state, data) {
            state.companyOffers.unshift(data);
        },

        SET_COMPANY_WORKERS(state, data) {
            state.companyWorkers = data;
        },

        SET_COMPANY_WORKERS_LOADING(state, data) {
            state.companyWorkersLoading = data;
        },

        SET_COMPANY_AGREEMENTS(state, data) {
            state.companyAgreements = data;
        },

        SET_COMPANY_AGREEMENTS_LOADING(state, data) {
            state.companyAgreementsLoading = data;
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
        },

        SET_COMPANIES_TO_VERIFICATION(state, data) {
            state.companiesToVerification = data;
        },

        SET_COMPANIES_TO_VERIFICATION_LOADING(state, data) {
            state.companiesToVerificationLoading = data;
        },

        SET_VERIFIED_COMPANIES(state, data) {
            state.verifiedCompanies = data;
        },

        SET_VERIFIED_COMPANIES_LOADING(state, data) {
            state.verifiedCompaniesLoading = data;
        },

        SET_CODE_LOADING(state, data) {
            state.codeLoading = data;
        },
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

        async fetchCompany({commit}, slug) {
            commit('SET_COMPANY_LOADING', true);
            try {
                let response = await axios.get(`/api/companies/${slug}`);
                commit('SET_COMPANY', response.data);
                commit('SET_COMPANY_LOADING', false);
            } catch (e) {
                commit('SET_COMPANY', '');
                commit('SET_COMPANY_LOADING', false);
            }
        },

        async fetchCompanyOffers({commit}, slug) {
            commit('SET_COMPANY_OFFERS_LOADING', true);
            try {
                let response = await axios.get(`/api/companies/${slug}/offers`);
                commit('SET_COMPANY_OFFERS', response.data);
                commit('SET_COMPANY_OFFERS_LOADING', false);
            } catch (e) {
                commit('SET_COMPANY_OFFERS', []);
                commit('SET_COMPANY_OFFERS_LOADING', false);
            }
        },

        async fetchCompanyWorkers({commit}, slug) {
            commit('SET_COMPANY_WORKERS_LOADING', true);
            try {
                let response = await axios.get(`/api/companies/${slug}/workers`);
                commit('SET_COMPANY_WORKERS', response.data);
                commit('SET_COMPANY_WORKERS_LOADING', false);
            } catch (e) {
                commit('SET_COMPANY_WORKERS', []);
                commit('SET_COMPANY_WORKERS_LOADING', false);
            }
        },

        async fetchCompanyAgreements({commit}, slug) {
            commit('SET_COMPANY_AGREEMENTS_LOADING', true);
            try {
                let response = await axios.get(`/api/companies/${slug}/agreements`);
                commit('SET_COMPANY_AGREEMENTS', response.data);
                commit('SET_COMPANY_AGREEMENTS_LOADING', false);
            } catch (e) {
                commit('SET_COMPANY_AGREEMENTS', []);
                commit('SET_COMPANY_AGREEMENTS_LOADING', false);
            }
        },

        async fetchInterns({commit}, id) {
            try {
                let response = await axios.get(`/api/companies/${id}/interns`);
                commit('SET_INTERNS', response.data.data);
            } catch (e) {
                commit('SET_INTERNS', []);
            }
        },

        async fetchCompanies({commit}) {
            commit('SET_COMPANIES_LOADING', true);
            try {
                let response = await axios.get(`/api/companies`);
                commit('SET_COMPANIES', response.data);
                commit('SET_COMPANIES_LOADING', false);
            } catch (e) {
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

        async generateCode({commit}, {slug}) {
            commit('SET_CODE_LOADING', true);
            try {
                let response = await axios.get(`/api/companies/${slug}/settings/generate-code`);
                commit('SET_CODE', response.data.access_code);
                commit('SET_CODE_LOADING', false);
            } catch (e) {
                commit('SET_CODE', null);
                commit('SET_CODE_LOADING', false);
            }
        },

        useCode({commit}, code) {
            return axios.post('/api/company/use-code', {
                accessCode: code
            });
        },

        updateCompanyLogo({commit}, {slug, data}) {
            return axios.post(`/api/companies/${slug}/settings/logo`, data, {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            });
        },

        updateCompanyData({commit}, {slug, data}) {
            return axios.put(`/api/companies/${slug}`, data);
        },

        acceptCompanyWorker({commit}, {slug, userId}) {
            return axios.put(`/api/companies/${slug}/workers/${userId}/accept`);
        },

        deleteCompanyWorker({commit}, {slug, userId}) {
            return axios.delete(`/api/companies/${slug}/workers/${userId}`);
        },

        addWorkerToCompany({commit}, {slug, userId, accessCode}) {
            return axios.post(`/api/companies/${slug}/workers/${userId}`, {
                accessCode: accessCode,
            });
        },

        verifyCompany({commit}, {slug}) {
            return axios.post(`/api/admin/companies/${slug}/verify`);
        },

        rejectCompany({commit}, {slug, reason}) {
            return axios.post(`/api/admin/companies/${slug}/reject`, {
                reason: reason
            });
        },

        async fetchCompaniesToVerification({commit}) {
            commit('SET_COMPANIES_TO_VERIFICATION_LOADING', true);
            try {
                let response = await axios.get(`/api/admin/companies/unverified`);
                commit('SET_COMPANIES_TO_VERIFICATION', response.data);
                commit('SET_COMPANIES_TO_VERIFICATION_LOADING', false);
            } catch (e) {
                commit('SET_COMPANIES_TO_VERIFICATION', []);
                commit('SET_COMPANIES_TO_VERIFICATION_LOADING', false);
            }
        },

        async fetchVerifiedCompanies({commit}) {
            commit('SET_VERIFIED_COMPANIES_LOADING', true);
            try {
                let response = await axios.get(`/api/admin/companies/verified`);
                commit('SET_VERIFIED_COMPANIES', response.data);
                commit('SET_VERIFIED_COMPANIES_LOADING', false);
            } catch (e) {
                commit('SET_COMPANIES_TO_VERIFICATION', []);
                commit('SET_VERIFIED_COMPANIES_LOADING', false);
            }
        },

        changeCompanyWorkerRoles({commit}, {slug, userId, userCompanyId, rolesIds}) {
            return axios.put(`/api/companies/${slug}/workers/${userId}/change-roles`, {
                userCompanyId: userCompanyId,
                rolesIds: rolesIds
            });
        },

        activeCompanyWorker({commit}, {slug, userId}) {
            return axios.put(`/api/companies/${slug}/workers/${userId}/activate`);
        },

        deactivateCompanyWorker({commit}, {slug, userId}) {
            return axios.put(`/api/companies/${slug}/workers/${userId}/deactivate`);
        }
    },
}
