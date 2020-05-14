import Vue from 'vue';

export default {
    state: {
        userStatuses: []
    },
    getters: {
        getAllUserStatuses: state => {
            return state.userStatuses;
        },
    },
    actions: {
        fetchUserStatuses({commit}) {
            return window.axios.get('api/user_statuses', {validateStatus: (status) => {
                    this.resStatus = status;
                    return status < 400;
                }})
                .then(res => {
                    commit('setUserStatuses', res.data);
                })
                .catch(err => {
                    console.log(err);
                });
        },
        addUserStatus({commit}, {name, description}){
            console.log(name, description);
            window.axios({
                method: 'post',
                url: 'api/user_statuses',
                headers: {'X-CSRF-TOKEN': window.Laravel.csrfToken},
                data: {
                    name: name,
                    description: description
                }
            }).then(res => {
                commit('addUserStatus', res.data);
            })
                .catch(err => {
                    console.log(err);
                });
        },
        deleteUserStatus({commit}, id)
        {
            window.axios({
                method: 'delete',
                headers: {'X-CSRF-TOKEN': window.Laravel.csrfToken},
                url: `api/user_statuses/${id}`
            }).then(res => {
                commit('deleteUserStatus', id);
            });
        }
    },
    mutations: {
        setUserStatuses(state, data) {
            state.userStatuses = data;
        },
        addUserStatus(state, data) {
            state.userStatuses.push(data);
        },
        deleteUserStatus(state, id) {
            state.userStatuses = state.userStatuses.filter(userStatus => userStatus.id !== id);
        }
    }
}
