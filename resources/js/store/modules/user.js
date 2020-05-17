import vue from "vue";
import router from "../../router/routers";

export default {
    state: {
        loggedUser: '',
        users: [],
        validationErrors: '',
    },
    getters: {

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
        }
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
    }
};
