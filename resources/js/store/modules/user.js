import vue from "vue";
import router from "../../router/routers";

export default {
    namespaced: true,

    state: {
        loggedUser: '',
        validationErrors: '',
        userUniversities: [],
        userCompanies: []
    },

    getters: {
        userUniversities(state) {
            return state.userUniversities;
        },

        userCompanies(state) {
            return state.userCompanies;
        }
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

        SET_USER_COMPANIES(state, data) {
            state.userCompanies = data;
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

        async fetchUserUniversities({ commit }) {
            try {
                let response = await axios.get('/api/user-universities');
                commit('SET_USER_UNIVERSITIES', response.data.data);
            } catch (e) {
                commit('SET_USER_UNIVERSITIES', []);
            }
        },

        async fetchUserCompanies({ commit }) {
            try {
                let response = await axios.get('/api/user-companies');
                commit('SET_USER_COMPANIES', response.data.data);
            } catch (e) {
                commit('SET_USER_COMPANIES', []);
            }
        }
    }
};
