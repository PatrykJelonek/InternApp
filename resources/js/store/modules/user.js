import vue from "vue";
import router from "../../router/routers";

export default {
    state: {
        loggedUser: {},
        users: [],
        validationErrors: '',
    },
    getters: {
        isAuthenticated: state => {
            return Object.keys(state.loggedUser).length > 0;
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
        loginUser({commit}, credentials)
        {
            window.axios({
                method: 'post',
                url: '/auth/login',
                headers: {'X-CSRF-TOKEN': window.Laravel.csrfToken},
                data: {
                    email: credentials.email,
                    password: credentials.password
                }
            }).then(res => {
                commit('LOGIN_USER', res.data);
            }).catch(err => {
                console.log(err.response.data);
            })
        },
    },
    mutations: {
        CREATE_USER_ACCOUNT(state, message) {
            state.validationErrors = '';
            console.log(message);
            router.push('/dashboard');
        },
        ACCOUNT_VALIDATION(state, errors)
        {
            state.validationErrors = errors;
        },
        LOGIN_USER(state, data) {
          state.loggedUser = data;
          router.push('/dashboard');
        },
        LOGOUT_USER(state, data) {
            state.loggedUser = null;
            router.push('/');
        },
    }
};
