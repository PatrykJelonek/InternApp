import vue from "vue";
import router from "../../router/routers";

export default {
    state: {
        loggedUser: '',
        users: [],
        validationErrors: '',
    },
    getters: {
        isAuthenticated: state => {
            return localStorage.getItem('user') != null;
        },
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
                url: '/api/login',
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
        logoutUser({commit})
        {
            commit('LOGOUT_USER');
        },
        fetchUserData({commit})
        {
            commit('FETCH_USER_DATA', JSON.parse(localStorage.getItem('user')));
        },
    },
    mutations: {
        CREATE_USER_ACCOUNT(state, message) {
            state.validationErrors = '';
            console.log(message);
            router.push('/login');
        },
        ACCOUNT_VALIDATION(state, errors)
        {
            state.validationErrors = errors;
        },
        LOGIN_USER(state, data) {
            localStorage.setItem('user', JSON.stringify(data));
            state.loggedUser = data.user;
            router.push('/dashboard');
        },
        LOGOUT_USER(state, data) {
            state.loggedUser = null;
            localStorage.removeItem('user');
            router.push('/');
        },
        FETCH_USER_DATA(state, data)
        {
            state.loggedUser = data.user;
        }
    }
};
