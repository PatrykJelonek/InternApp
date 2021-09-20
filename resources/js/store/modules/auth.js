import Vue from 'vue';
import store from "../index";

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

            let universityFromStorage = JSON.parse(localStorage.getItem('SELECTED_UNIVERSITY'));

            if (universityFromStorage) {
                store.commit( 'university/SET_UNIVERSITY', universityFromStorage);
            } else if (data.universities.length > 0) {
                store.dispatch('university/fetchUniversity', [data.universities[0].slug]);
            }
        },

        CHANGE_USER_DATA (state, data) {
            state.user.first_name = data.firstName;
            state.user.last_name = data.lastName;
            state.user.phone = data.phone;
        },

        CHANGE_USER_AVATAR(state, path) {
            state.user.avatar_url = path;
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
            });

            dispatch('attempt', response.data.token);

            return response;
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

        updateUserData({commit}, data) {
            return axios.put(`/api/me/personal-data`, data);
        },

        updateUserPassword({commit}, data) {
            return axios.put(`/api/me/password`, data);
        },

        updateUserAvatar({commit}, data) {
            return axios.post(`/api/me/avatar`, data, {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            });
        },

        forgotPassword({commit}, email) {
            return axios.post(`/api/forgot-password`, {
                email: email,
            });
        },

        resetPassword({commit}, data) {
            return axios.post(`/api/reset-password`, data);
        }
    }
};
