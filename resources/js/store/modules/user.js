import vue from "vue";

export default {
    state: {
        users: []
    },
    getters: {

    },
    actions: {
        createUserAccount({commit}, account) {
            console.log(account);
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
            })
                .catch(err => {
                    console.log(err);
                });
        },
    },
    mutations: {
        CREATE_USER_ACCOUNT(state, message) {
            console.log(message);
        },
    }
};
