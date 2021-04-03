import vue from "vue";
import router from "../../router/routers";

export default {
    namespaced: true,

    state: {
        loggedUser: '',
        validationErrors: '',
        userUniversities: [],
        userCompanies: [],
        roles: [],
        journalEntries: [],
        internships: [],
        interns: [],
        newInternships: [],
        userUniversitiesLoading: true,
    },

    getters: {
        userUniversities(state) {
            return state.userUniversities;
        },

        userUniversitiesLoading(state) {
            return state.userUniversitiesLoading;
        },

        userCompanies(state) {
            return state.userCompanies;
        },

        roles(state) {
            return state.roles;
        },

        journalEntries(state) {
            return state.journalEntries;
        },

        internships(state) {
            return state.internships;
        },

        newInternships(state) {
            return state.newInternships;
        },

        interns(state) {
            return state.interns;
        },
    },

    mutations: {
        CREATE_USER_ACCOUNT(state, message) {
            state.validationErrors = '';
            console.log(message);
            router.push('/login');
        },

        ACCOUNT_VALIDATION(state, errors) {
            state.validationErrors = errors;
        },

        SET_USER_UNIVERSITIES(state, data) {
            state.userUniversities = data;
        },

        SET_USER_UNIVERSITIES_LOADING(state, data) {
            state.userUniversitiesLoading = data;
        },

        SET_USER_COMPANIES(state, data) {
            state.userCompanies = data;
        },

        SET_ROLES(state, data) {
            state.roles = data;
        },

        SET_JOURNALS_ENTRIES(state, data) {
            state.journalEntries = data;
        },

        SET_INTERNSHIPS(state, data) {
            state.internships = data;
        },

        SET_NEW_INTERNSHIPS(state, data) {
            state.newInternships = data;
        },

        SET_INTERNS(state, data) {
            state.interns = data;
        }
    },

    actions: {
        createUserAccount({commit}, account) {
            window.axios({
                method: 'post',
                url: '/api/users',
                headers: {'X-CSRF-TOKEN': window.Laravel.csrfToken},
                data: {
                    firstName: account.firstName,
                    lastName: account.lastName,
                    email: account.email,
                    phone: account.phone,
                    password: account.password,
                }
            }).then(res => {
                commit('CREATE_USER_ACCOUNT', res.data);
            }).catch(err => {
                if (err.response.status == 422){
                    commit('ACCOUNT_VALIDATION', err.response.data.errors)
                }
            });
        },

        createUser({commit}, user) {
          return axios.post('/api/users', user);
        },

        async fetchUserUniversities({ commit }) {
            commit('SET_USER_UNIVERSITIES_LOADING', true);
            try {
                let response = await axios.get('/api/me/universities');
                commit('SET_USER_UNIVERSITIES', response.data);
                commit('SET_USER_UNIVERSITIES_LOADING', false);
            } catch (e) {
                commit('SET_USER_UNIVERSITIES', []);
                commit('SET_USER_UNIVERSITIES_LOADING', false);
            }
        },

        async fetchUserCompanies({ commit }) {
            try {
                let response = await axios.get('/api/user-companies');
                commit('SET_USER_COMPANIES', response.data.data);
            } catch (e) {
                commit('SET_USER_COMPANIES', []);
            }
        },

        async fetchUserRoles({ commit }) {
          try {
              let response = await axios.get('/api/user/roles');
              commit('SET_ROLES', response.data.data);
          } catch (e) {
              commit('SET_ROLES', []);
          }
        },

        async fetchJournalEntries({ commit }) {
            try {
                let response = await axios.get('/api/journals');
                commit('SET_JOURNALS_ENTRIES', response.data.data);
            } catch(e) {
                commit('SET_JOURNALS_ENTRIES', []);
            }
        },

        async fetchInternships({ commit }) {
            try {
                let response = await axios.get('/api/user/internships');
                commit('SET_INTERNSHIPS', response.data.data);
            } catch (e) {
                commit('SET_INTERNSHIPS', []);
            }
        },

        async fetchInterns({commit}, id) {
            try {
                let response = await axios.get(`/api/user/interns`);
                commit('SET_INTERNS', response.data.data);
            } catch(e) {
                commit('SET_INTERNS', []);
            }
        },

        async fetchNewInternships({ commit }) {
            try {
                let response = await axios.get('/api/me/internships');
                commit('SET_NEW_INTERNSHIPS', response.data);
            } catch (e) {
                commit('SET_NEW_INTERNSHIPS', []);
            }
        }
    }
};
