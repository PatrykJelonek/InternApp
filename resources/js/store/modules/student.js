export default {
    namespaced: true,

    state: {
        student: '',
        students: [],
    },

    getters: {
        student(state) {
            return state.student;
        },

        students(state) {
            return state.students;
        }
    },

    mutations: {
        SET_STUDENT(state, data) {
            state.student = data;
        },

        SET_STUDENTS(state, data) {
            state.students = data;
        }
    },

    actions: {
        createStudent({commit}, data) {
            return axios.post('/api/students', data);
        }
    },
}
