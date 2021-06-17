export default {
    namespaced: true,

    state: {
        questionnaires: [],
        isQuestionnairesLoading: false,
    },

    getters: {
        questionnaires(state) {
            return state.questionnaires;
        },

        isQuestionnairesLoading(state) {
            return state.isQuestionnairesLoading;
        }
    },

    mutations: {
        SET_QUESTIONNAIRES(state, data) {
            state.questionnaires = data;
        },

        SET_QUESTIONNAIRES_LOADING(state, data) {
            state.isQuestionnairesLoading = data;
        }
    },

    actions: {
        async fetchCompanyQuestionnaires({commit}, slug) {
            commit('SET_QUESTIONNAIRES_LOADING', true);
            try {
                let response = await axios.get(`/api/companies/${slug}/questionnaires`);
                commit('SET_QUESTIONNAIRES', response.data);
                commit('SET_QUESTIONNAIRES_LOADING', false);
            } catch(e) {
                commit('SET_QUESTIONNAIRES', []);
                commit('SET_QUESTIONNAIRES_LOADING', false);
            }
        },

        async fetchUniversitiesQuestionnaires({commit}, slug) {
            commit('SET_QUESTIONNAIRES_LOADING', true);
            try {
                let response = await axios.get(`/api/universities/${slug}/questionnaires`);
                commit('SET_SPECIALIZATIONS', response.data);
                commit('SET_QUESTIONNAIRES_LOADING', false);
            } catch(e) {
                commit('SET_QUESTIONNAIRES', []);
                commit('SET_QUESTIONNAIRES_LOADING', false);
            }
        },
    },
}
