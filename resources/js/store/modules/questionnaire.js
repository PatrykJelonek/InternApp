import axios from "axios";

export default {
    namespaced: true,

    state: {
        questionnaire: null,
        isQuestionnaireLoading: false,
        questionnaires: [],
        isQuestionnairesLoading: false,
        questionnaireAnswers: [],
        isQuestionnaireAnswersLoading: false,
        questionnaireQuestions: [],
        isQuestionnaireQuestionsLoading: false,
    },

    getters: {
        questionnaire(state) {
            return state.questionnaire;
        },

        isQuestionnaireLoading(state) {
            return state.isQuestionnaireLoading;
        },

        questionnaires(state) {
            return state.questionnaires;
        },

        isQuestionnairesLoading(state) {
            return state.isQuestionnairesLoading;
        },

        // questionnaireQuestions: (state) => (questionnaireId) => {
        //     state.questionnaires.forEach((questionnaire) => {
        //         if (questionnaire.id === questionnaireId) {
        //             return questionnaire.questions;
        //         }
        //     })
        // },

        questionnaireAnswers(state) {
            return state.questionnaireAnswers;
        },

        isQuestionnaireAnswersLoading(state) {
            return state.isQuestionnaireAnswersLoading;
        },

        questionnaireQuestions(state) {
            return state.questionnaireQuestions;
        },

        isQuestionnaireQuestionsLoading(state) {
            return state.isQuestionnaireQuestionsLoading;
        },
    },

    mutations: {
        SET_QUESTIONNAIRE(state, data) {
            state.questionnaire = data;
        },

        SET_QUESTIONNAIRE_LOADING(state, data) {
            state.isQuestionnaireLoading = data;
        },

        SET_QUESTIONNAIRES(state, data) {
            state.questionnaires = data;
        },

        SET_QUESTIONNAIRES_LOADING(state, data) {
            state.isQuestionnairesLoading = data;
        },

        ADD_QUESTIONNAIRE(state, data) {
            state.questionnaires.push(data);
        },

        // SET_QUESTIONNAIRE_QUESTIONS(state, {questionnaireId, data}) {
        //     state.questionnaires.forEach((questionnaire) => {
        //         if (questionnaire.id === questionnaireId) {
        //             console.log(data);
        //             questionnaire.questions = data;
        //         }
        //     });
        // },

        SET_QUESTIONNAIRE_ANSWERS(state, data) {
            state.questionnaireAnswers = data;
        },

        SET_QUESTIONNAIRE_ANSWERS_LOADING(state, data) {
            state.isQuestionnaireAnswersLoading = data;
        },

        SET_QUESTIONNAIRE_QUESTIONS(state, data) {
            state.questionnaireQuestions = data;
        },

        SET_QUESTIONNAIRE_QUESTIONS_LOADING(state, data) {
            state.isQuestionnaireQuestionsLoading = data;
        },
    },

    actions: {
        async fetchQuestionnaire({commit}, id) {
            commit('SET_QUESTIONNAIRE_LOADING', true);
            try {
                let response = await axios.get(`/api/questionnaires/${id}`);
                commit('SET_QUESTIONNAIRE', response.data);
                commit('SET_QUESTIONNAIRE_LOADING', false);
            } catch (e) {
                commit('SET_QUESTIONNAIRE', []);
                commit('SET_QUESTIONNAIRE_LOADING', false);
            }
        },

        async fetchCompanyQuestionnaires({commit}, slug) {
            commit('SET_QUESTIONNAIRES_LOADING', true);
            try {
                let response = await axios.get(`/api/companies/${slug}/questionnaires`);
                commit('SET_QUESTIONNAIRES', response.data);
                commit('SET_QUESTIONNAIRES_LOADING', false);
            } catch (e) {
                commit('SET_QUESTIONNAIRES', []);
                commit('SET_QUESTIONNAIRES_LOADING', false);
            }
        },

        async fetchUniversitiesQuestionnaires({commit}, slug) {
            commit('SET_QUESTIONNAIRES_LOADING', true);
            try {
                let response = await axios.get(`/api/universities/${slug}/questionnaires`);
                commit('SET_QUESTIONNAIRES', response.data);
                commit('SET_QUESTIONNAIRES_LOADING', false);
            } catch (e) {
                commit('SET_QUESTIONNAIRES', []);
                commit('SET_QUESTIONNAIRES_LOADING', false);
            }
        },

        async fetchQuestionnaireAnswers({commit}, id) {
            commit('SET_QUESTIONNAIRE_ANSWERS_LOADING', true);
            try {
                let response = await axios.get(`/api/questionnaires/${id}/answers`);
                commit('SET_QUESTIONNAIRE_ANSWERS', response.data);
                commit('SET_QUESTIONNAIRE_ANSWERS_LOADING', false);
            } catch (e) {
                commit('SET_QUESTIONNAIRE_ANSWERS', []);
                commit('SET_QUESTIONNAIRE_ANSWERS_LOADING', false);
            }
        },

        async fetchQuestionnaireQuestions({commit}, id) {
            commit('SET_QUESTIONNAIRE_QUESTIONS_LOADING', true);
            try {
                let response = await axios.get(`/api/questionnaires/${id}/questions`);
                commit('SET_QUESTIONNAIRE_QUESTIONS', response.data);
                commit('SET_QUESTIONNAIRE_QUESTIONS_LOADING', false);
            } catch (e) {
                commit('SET_QUESTIONNAIRE_QUESTIONS', []);
                commit('SET_QUESTIONNAIRE_QUESTIONS_LOADING', false);
            }
        },

        addQuestionnaire({commit}, data) {
            commit('ADD_QUESTIONNAIRE', data);
        },

        createCompanyQuestionnaire({commit}, {slug, questionnaire}) {
            return axios.post(`/api/companies/${slug}/questionnaires`, questionnaire);
        },

        createUniversityQuestionnaire({commit}, {slug, questionnaire}) {
            return axios.post(`/api/universities/${slug}/questionnaires`, questionnaire);
        },

        modifyQuestionnaireQuestions({commit}, {id, questions}) {
            return axios.post(`/api/questionnaires/${id}/questions`, {
                questions: questions
            });
        },

        addQuestionnaireAnswers({commit}, {id, answers}) {
            return axios.post(`/api/questionnaires/${id}/answers`, {
                answers: answers
            });
        },

        setQuestionnaireQuestions({commit}, {id, questions}) {
            commit('SET_QUESTIONNAIRE_QUESTIONS', {questionnaireId: id, data: questions});
        },

        updateQuestionnaire({commit}, {id, name, description}) {
            return axios.put(`/api/questionnaires/${id}`, {
                name: name,
                description: description
            });
        }
    },
}
