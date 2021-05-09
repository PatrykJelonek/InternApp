export default {
    namespaced: true,

    state: {
        userChats: [],
        userChatsLoading: true,
        chatMessages: [],
        chatMessagesLoading: true,
    },

    getters: {
        userChats(state) {
            return state.userChats;
        },

        userChatsLoading(state) {
            return state.userChatsLoading;
        },

        chatMessages(state) {
            return state.chatMessages;
        },

        chatMessagesLoading(state) {
            return state.chatMessagesLoading;
        },
    },

    mutations: {
        SET_USER_CHATS(state, data) {
            state.userChats = data;
        },

        SET_USER_CHATS_LOADING(state, data) {
            state.userChatsLoading = data;
        },

        SET_CHAT_MESSAGES(state, data) {
            state.chatMessages = data;
        },

        SET_CHAT_MESSAGES_LOADING(state, data) {
            state.chatMessagesLoading = data;
        },
    },

    actions: {
        async fetchUserChats({commit}) {
            commit('SET_USER_CHATS_LOADING', true);
            try {
                let response = await axios.get('/api/me/chats');
                commit('SET_USER_CHATS', response.data);
                commit('SET_USER_CHATS_LOADING', false);
            } catch (e) {
                commit('SET_USER_CHATS', []);
                commit('SET_USER_CHATS_LOADING', false);
            }
        },

        async fetchChatMessages({commit}, {uuid, page}) {
            commit('SET_CHAT_MESSAGES_LOADING', true);
            try {
                let response = await axios.get(`/api/chats/${uuid}`, {
                    params: {
                        page: page
                    }
                });
                commit('SET_CHAT_MESSAGES', response.data);
                commit('SET_CHAT_MESSAGES_LOADING', false);
            } catch (e) {
                commit('SET_CHAT_MESSAGES', []);
                commit('SET_CHAT_MESSAGES_LOADING', false);
            }
        },

        sendMessage({commit}, {uuid, message}) {
            return axios.post(`/api/chats/${uuid}`, {
                message: message
            });
        }
    }
}
