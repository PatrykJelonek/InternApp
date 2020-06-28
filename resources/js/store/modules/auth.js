import Vue from 'vue';

export default {
    namespaced: true,

    state: {
        token: null,
        user: null
    },

    getters: {
        authenticated (state) {
            return state.token && state.user;
        },

        user(state) {
            return state.user;
        },

        roles(state) {
            return state.user.roles.map(o => o['name']);
        }
    },

    mutations: {
        SET_TOKEN (state, token) {
            state.token = token;
        },

        SET_USER (state, data) {
            state.user = data;
        }
    },

    actions: {
        async signIn ({ dispatch }, credentials) {
            let response = await window.axios({
                method: 'post',
                url: '/api/login',
                headers: {'X-CSRF-TOKEN': window.Laravel.csrfToken},
                data: {
                    email: credentials.email,
                    password: credentials.password
                }
            }).catch((error) => {
                console.log(error);
            })

            dispatch('attempt', response.data.token);
        },

        async attempt ({ commit, state }, token) {
            if(token)
                commit('SET_TOKEN', token);

            if(!state.token)
                return;

            try {
                let response = await axios.get('/api/me');
                commit('SET_USER', response.data.data);
            } catch (e) {
                console.log(e);
                commit('SET_TOKEN', null);
                commit('SET_USER', null);
            }
        },

        signOut ({ commit }) {
            return axios.post('/api/logout').then(() => {
                commit('SET_TOKEN', null);
                commit('SET_USER', null);
            });
        },
    }
};
