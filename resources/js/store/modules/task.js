export default {
    namespaced: true,

    state: {
        task: null,
        tasks: [],
    },

    getters: {
        task(state) {
            return state.task;
        },

        tasks(state) {
            return state.tasks;
        },
    },

    mutations: {
        SET_TASK(state, data) {
            state.task = data;
        },

        SET_TASKS(state, data) {
            state.tasks = data;
        },
    },

    actions: {
        async fetchTask({commit}, internshipId, taskId) {
            try {
                let response = await axios.get(`/api/internships/${internshipId}/tasks/${taskId}`);
                commit('SET_TASK', response.data);
            } catch (e) {
                commit('SET_TASK', []);
            }
        },

        async fetchTasks({commit}, internshipId) {
            try {
                let response = await axios.get(`/api/internships/${internshipId}/tasks`);
                commit('SET_TASKS', response.data);
            } catch (e) {
                commit('SET_TASKS', []);
            }
        },

        deleteStudentTask({commit}, {internshipId, studentIndex, taskId}) {
            return axios.delete(`/api/internships/${internshipId}/students/${studentIndex}/tasks/${taskId}`);
        },

        acceptStudentTask({commit}, {internshipId, studentIndex, taskId}) {
            return axios.put(`/api/internships/${internshipId}/students/${studentIndex}/tasks/${taskId}/accept`);
        },
    },
}
