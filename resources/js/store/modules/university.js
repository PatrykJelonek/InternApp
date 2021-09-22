import agreement from "./agreement";

export default {
    namespaced: true,

    state: {
        selectedUniversityId: '',
        selectedUniversity: null,
        universities: [],
        universitiesLoading: false,
        universitiesToVerification: [],
        universitiesToVerificationLoading: false,
        universityTypes: [],
        universityUsers: [],
        universityAgreements: [],
        universityOffers: [],
        universityOffersLoading: false,
        internships: [],
        internshipsLoading: false,
        students: [],
        studentsLoading: false,
        university: null,
        universityLoading: false,
        workers: [],
        workersLoading: false,
        agreements: [],
        agreementsLoading: false,
        faculties: [],
        facultiesLoading: false,
        codeLoading: false,
        availableStudentOffers: [],
        availableStudentOffersLoading: false,
        facultiesTreeView: [],
    },

    getters: {
        universities: state => {
            return state.universities;
        },

        universitiesLoading: state => {
            return state.universitiesLoading;
        },

        universitiesToVerification: state => {
            return state.universitiesToVerification;
        },

        universitiesToVerificationLoading: state => {
            return state.universitiesToVerificationLoading;
        },

        university: state => {
            return state.university;
        },

        universityLoading: state => {
            return state.universityLoading;
        },

        universityTypes: (state) => {
            return state.universityTypes;
        },

        selectedUniversity: (state) => {
            return state.selectedUniversity;
        },

        universityUsers: (state) => {
            return state.universityUsers;
        },

        universityAgreements: (state) => {
            return state.universityAgreements;
        },

        internships: (state) => {
            return state.internships;
        },

        internshipsLoading: (state) => {
            return state.internshipsLoading;
        },

        selectedUniversityId: (state) => {
            return state.selectedUniversityId;
        },

        students: (state) => {
            return state.students;
        },

        studentsLoading: (state) => {
            return state.studentsLoading;
        },

        workers: (state) => {
            return state.workers;
        },

        workersLoading: (state) => {
            return state.workersLoading;
        },

        agreements: (state) => {
            return state.agreements;
        },

        agreementsLoading: (state) => {
            return state.agreementsLoading;
        },

        faculties: (state) => {
            return state.faculties;
        },

        facultiesLoading: (state) => {
            return state.facultiesLoading;
        },

        codeLoading: (state) => {
            return state.codeLoading;
        },

        availableOffers(state) {
            return state.availableStudentOffers;
        },

        availableOffersLoading(state) {
            return state.availableStudentOffersLoading;
        },

        facultiesTreeView(state) {
            return state.facultiesTreeView;
        },

        universityOffers(state) {
            return state.universityOffers;
        },

        universityOffersLoading(state) {
            return state.universityOffersLoading;
        },
    },

    mutations: {
        SET_UNIVERSITIES(state, data) {
            state.universities = data;
        },

        SET_UNIVERSITIES_LOADING(state, data) {
            state.universitiesLoading = data;
        },

        SET_UNIVERSITIES_TO_VERIFICATION(state, data) {
            state.universitiesToVerification = data;
        },

        SET_UNIVERSITIES_TO_VERIFICATION_LOADING(state, data) {
            state.universitiesToVerificationLoading = data;
        },

        SET_UNIVERSITY_TYPES(state, data) {
            state.universityTypes = data;
        },

        SET_SELECTED_UNIVERSITY(state, university) {
            state.selectedUniversity = university;
        },

        SET_CODE(state, accessCode) {
            state.university.access_code = accessCode;
        },

        SET_CODE_LOADING(state, data) {
            state.codeLoading = data;
        },

        SET_UNIVERSITY_USERS(state, data) {
            state.universityUsers = data;
        },

        SET_UNIVERSITY_AGREEMENTS(state, data) {
            state.universityAgreements = data;
        },

        SET_INTERNSHIPS(state, data) {
            state.internships = data;
        },

        SET_INTERNSHIPS_LOADING(state, data) {
            state.internshipsLoading = data;
        },

        SET_SELECTED_UNIVERSITY_ID(state, data) {
            state.selectedUniversityId = data;
        },

        SET_STUDENTS(state, data) {
            state.students = data;
        },

        SET_STUDENTS_LOADING(state, data) {
            state.studentsLoading = data;
        },

        SET_UNIVERSITY(state, data) {
            state.university = data;
        },

        SET_UNIVERSITY_LOADING(state, data) {
            state.universityLoading = data;
        },

        SET_WORKERS(state, data) {
            state.workers = data;
        },

        SET_WORKERS_LOADING(state, data) {
            state.workersLoading = data;
        },

        SET_AGREEMENTS(state, data) {
            state.agreements = data;
        },

        SET_AGREEMENTS_LOADING(state, data) {
            state.agreementsLoading = data;
        },

        SET_FACULTIES(state, data) {
            state.faculties = data;
        },

        SET_FACULTIES_LOADING(state, data) {
            state.facultiesLoading = data;
        },

        SET_AVAILABLE_OFFERS(state, data) {
            state.availableStudentOffers = data;
        },

        SET_AVAILABLE_OFFERS_LOADING(state, data) {
            state.availableStudentOffersLoading = data;
        },

        SET_UNIVERSITY_AGREEMENT_ACTIVE_STATUS(state, {slug, data}) {
            state.agreements.map((agreement) => {
                if (agreement.slug === slug) {
                    agreement.is_active = data;
                }

                return agreement;
            });
        },

        SET_FACULTIES_TREE_VIEW(state, data) {
            state.facultiesTreeView = [];

            data.forEach((faculty) => {
                let fields = [];
                faculty.fields.forEach((field) => {
                    let specializations = [];
                    field.specializations.forEach((specialization) => {
                        specializations.push({
                            id: specialization.id,
                            name: specialization.name,
                            facultyId: faculty.id,
                            fieldId: field.id,
                            fieldName: field.name,
                            type: 'specialization'
                        })
                    });
                    fields.push({
                        id: field.id,
                        name: field.name,
                        facultyId: faculty.id,
                        facultyName: faculty.name,
                        children: specializations,
                        type: 'field'
                    });
                });
                state.facultiesTreeView.push({
                    id: faculty.id,
                    name: faculty.name,
                    type: 'faculty',
                    children: fields,
                });
            });
        },

        DELETE_UNIVERSITY_AGREEMENT(state, {slug}) {
            state.agreements = state.agreements.filter((agreement) => {
                return agreement.slug !== slug;
            })
        },

        CHANGE_UNIVERSITY_INTERNSHIP_STATUS(state, {id, status, hexColor}) {
            state.internships.map((internship) => {
                if (internship.id === id) {
                    internship.status.display_name = status;
                    internship.status.hex_color = hexColor;
                }

                return internship;
            });
        },

        SET_UNIVERSITY_OFFERS(state, data) {
            state.universityOffers = data;
        },

        SET_UNIVERSITY_OFFERS_LOADING(state, data) {
            state.universityOffersLoading = data;
        },
    },

    actions: {
        async fetchUniversities({commit}) {
            commit('SET_UNIVERSITIES_LOADING', true);
            try {
                let response = await axios.get('/api/universities');
                commit('SET_UNIVERSITIES', response.data);
                commit('SET_UNIVERSITIES_LOADING', false);
            } catch (e) {
                commit('SET_UNIVERSITIES', []);
                commit('SET_UNIVERSITIES_LOADING', false);
            }
        },

        async fetchUniversityTypes({commit}) {
            try {
                let response = await axios.get('/api/university-types');
                commit('SET_UNIVERSITY_TYPES', response.data.data);
            } catch (e) {
                commit('SET_UNIVERSITY_TYPES', []);
            }
        },

        async fetchUniversityUsers({commit}, id) {
            try {
                let response = await axios.get(`/api/universities/${id}/users`);
                commit('SET_UNIVERSITY_USERS', response.data.data);
            } catch (e) {
                commit('SET_UNIVERSITY_USERS', []);
            }
        },

        async fetchUniversityAgreements({commit}, id) {
            try {
                let response = await axios.get(`/api/universities/${id}/agreements`);
                commit('SET_UNIVERSITY_AGREEMENTS', response.data.data);
            } catch (e) {
                commit('SET_UNIVERSITY_AGREEMENTS', []);
            }
        },

        async fetchInternships({commit}, slug) {
            commit('SET_INTERNSHIPS_LOADING', true);
            try {
                let response = await axios.get(`/api/universities/${slug}/internships`);
                commit('SET_INTERNSHIPS', response.data);
                commit('SET_INTERNSHIPS_LOADING', false);
            } catch (e) {
                commit('SET_INTERNSHIPS', []);
                commit('SET_INTERNSHIPS_LOADING', false);
            }
        },

        async fetchFaculties({commit}, slug) {
            commit('SET_FACULTIES_LOADING', true);
            try {
                let response = await axios.get(`/api/universities/${slug}/faculties`);
                commit('SET_FACULTIES', response.data);
                commit('SET_FACULTIES_TREE_VIEW', response.data);
                commit('SET_FACULTIES_LOADING', false);
            } catch (e) {
                commit('SET_FACULTIES', []);
                commit('SET_FACULTIES_LOADING', false);
            }
        },

        createUniversity({commit}, university) {
            return axios.post('/api/universities', university);
        },

        selectUniversity({commit}, university) {
            commit('SET_SELECTED_UNIVERSITY', university);
        },

        selectUniversityId({commit}, id) {
            commit('SET_SELECTED_UNIVERSITY_ID', id);
        },

        async generateCode({commit}, id) {
            commit('SET_CODE_LOADING', true);
            try {
                let response = await axios.post('/api/university/generate-code', {
                    id: id
                });
                commit('SET_CODE', response.data.data);
                commit('SET_CODE_LOADING', false);
            } catch (e) {
                commit('SET_CODE', e.response.data.message);
                commit('SET_CODE_LOADING', false);
            }
        },

        useCode({commit}, accessCode) {
            return axios.post('/api/university/use-code', {
                accessCode: accessCode
            });
        },

        async fetchStudents({commit}, slug) {
            commit('SET_STUDENTS_LOADING', true);
            try {
                let response = await axios.get(`/api/universities/${slug}/students`);
                commit('SET_STUDENTS', response.data);
                commit('SET_STUDENTS_LOADING', false);
            } catch (e) {
                commit('SET_STUDENTS', []);
                commit('SET_STUDENTS_LOADING', false);
            }
        },

        async fetchWorkers({commit}, slug) {
            commit('SET_WORKERS_LOADING', true);
            try {
                let response = await axios.get(`/api/universities/${slug}/workers`);
                commit('SET_WORKERS', response.data);
                commit('SET_WORKERS_LOADING', false);
            } catch (e) {
                commit('SET_WORKERS', []);
                commit('SET_WORKERS_LOADING', false);
            }
        },

        async fetchAgreements({commit}, slug) {
            commit('SET_AGREEMENTS_LOADING', true);
            try {
                let response = await axios.get(`/api/universities/${slug}/agreements`);
                commit('SET_AGREEMENTS', response.data);
                commit('SET_AGREEMENTS_LOADING', false);
            } catch (e) {
                commit('SET_AGREEMENTS', []);
                commit('SET_AGREEMENTS_LOADING', false);
            }
        },

        async fetchUniversity({commit}, slug) {
            commit('SET_UNIVERSITY_LOADING', true);
            try {
                let response = await axios.get(`/api/universities/${slug}`);
                commit('SET_UNIVERSITY', response.data);
                commit('SET_UNIVERSITY_LOADING', false);
            } catch (e) {
                commit('SET_UNIVERSITY', []);
                commit('SET_UNIVERSITY_LOADING', false);
            }
        },

        async fetchUniversitiesToVerification({commit}) {
            commit('SET_UNIVERSITIES_TO_VERIFICATION_LOADING', true);
            try {
                let response = await axios.get(`/api/admin/universities/unverified`);
                commit('SET_UNIVERSITIES_TO_VERIFICATION', response.data);
                commit('SET_UNIVERSITIES_TO_VERIFICATION_LOADING', false);
            } catch (e) {
                commit('SET_UNIVERSITIES_TO_VERIFICATION', []);
                commit('SET_UNIVERSITIES_TO_VERIFICATION_LOADING', false);
            }
        },

        async fetchAvailableOffers({commit}) {
            commit('SET_AVAILABLE_OFFERS_LOADING', true);
            try {
                let response = await axios.get(`/api/me/offers`);
                commit('SET_AVAILABLE_OFFERS', response.data);
                commit('SET_AVAILABLE_OFFERS_LOADING', false);
            } catch (e) {
                commit('SET_AVAILABLE_OFFERS', []);
                commit('SET_AVAILABLE_OFFERS_LOADING', false);
            }
        },

        updateUniversityLogo({commit}, {slug, data}) {
            return axios.post(`/api/universities/${slug}/settings/logo`, data, {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            });
        },

        createUniversityFaculty({commit}, {slug, data}) {
            return axios.post(`/api/universities/${slug}/faculties`, data);
        },

        createUniversityFacultyField({commit}, {slug, facultyId, data}) {
            return axios.post(`/api/universities/${slug}/faculties/${facultyId}/fields`, data);
        },

        createUniversityFacultyFieldSpecialization({commit}, {slug, facultyId, fieldId, data}) {
            return axios.post(`/api/universities/${slug}/faculties/${facultyId}/fields/${fieldId}/specializations`, data);
        },

        updateUniversityFaculty({commit}, {slug, facultyId, data}) {
            return axios.put(`/api/universities/${slug}/faculties/${facultyId}`, data);
        },

        updateUniversityFacultyField({commit}, {slug, facultyId, fieldId, data}) {
            return axios.put(`/api/universities/${slug}/faculties/${facultyId}/fields/${fieldId}`, data);
        },

        updateUniversityFacultyFieldSpecialization({commit}, {slug, facultyId, fieldId, specializationId, data}) {
            return axios.put(`/api/universities/${slug}/faculties/${facultyId}/fields/${fieldId}/specializations/${specializationId}`, data);
        },

        deleteUniversityFaculty({commit}, {slug, facultyId}) {
            return axios.delete(`/api/universities/${slug}/faculties/${facultyId}`);
        },

        deleteUniversityFacultyField({commit}, {slug, facultyId, fieldId}) {
            return axios.delete(`/api/universities/${slug}/faculties/${facultyId}/fields/${fieldId}`);
        },

        deleteUniversityFacultyFieldSpecialization({commit}, {slug, facultyId, fieldId, specializationId}) {
            return axios.delete(`/api/universities/${slug}/faculties/${facultyId}/fields/${fieldId}/specializations/${specializationId}`);
        },

        setUniversityAgreementActiveStatus({commit}, {slug, data}) {
            commit('SET_UNIVERSITY_AGREEMENT_ACTIVE_STATUS', {slug: slug, data: data});
        },

        deleteUniversityAgreement({commit}, {slug}) {
            commit('DELETE_UNIVERSITY_AGREEMENT', {slug: slug});
        },

        changeUniversityWorkerRoles({commit}, {slug, userId, userUniversityId, rolesIds}) {
            return axios.put(`/api/universities/${slug}/workers/${userId}/change-roles`, {
                userUniversityId: userUniversityId,
                rolesIds: rolesIds
            });
        },

        verifyUniversityWorker({commit}, {slug, userId, userUniversityId}) {
            return axios.put(`/api/universities/${slug}/workers/${userId}/verify`, {
                userUniversityId: userUniversityId,
            });
        },

        rejectUniversityWorker({commit}, {slug, userId, reason}) {
            return axios.put(`/api/universities/${slug}/workers/${userId}/reject`, {
                reason: reason
            });
        },

        addWorkerToUniversity({commit}, {slug, userId, accessCode}) {
            return axios.post(`/api/universities/${slug}/workers/${userId}`, {
                accessCode: accessCode,
            });
        },

        addStudentToUniversity({commit}, {slug, userId, student}) {
            return axios.post(`/api/universities/${slug}/students/${userId}`, student);
        },

        createOwnAgreement({commit}, {slug, data}) {
            return axios.post(`/api/universities/${slug}/agreements`, data);
        },

        verifyUniversity({commit}, {slug}) {
            return axios.post(`/api/admin/universities/${slug}/verify`);
        },

        rejectUniversity({commit}, {slug, reason}) {
            return axios.post(`/api/admin/universities/${slug}/reject`, {
                reason: reason
            });
        },

        verifyStudentInUniversity({commit}, {slug, userId}) {
            return axios.post(`/api/universities/${slug}/students/${userId}/verify`);
        },

        rejectStudentInUniversity({commit}, {slug, userId, reason}) {
            return axios.post(`/api/universities/${slug}/students/${userId}/reject`, {
                reason: reason,
            });
        },

        async fetchUniversityOffers({commit}, {slug}) {
            commit('SET_UNIVERSITY_OFFERS_LOADING', true);
            try {
                let response = await axios.get(`/api/universities/${slug}/offers`);
                commit('SET_UNIVERSITY_OFFERS', response.data);
                commit('SET_UNIVERSITY_OFFERS_LOADING', false);
            } catch (e) {
                commit('SET_UNIVERSITIES', []);
                commit('SET_UNIVERSITY_OFFERS_LOADING', false);
            }
        },

        updateUniversityData({commit}, {slug, email, website, phone}) {
            return axios.put(`/api/universities/${slug}/`, {
                email: email,
                website: website,
                phone: phone
            })
        },

        activeUniversityWorker({commit}, {slug, userId}) {
            return axios.put(`/api/universities/${slug}/workers/${userId}/activate`);
        },

        deactivateUniversityWorker({commit}, {slug, userId}) {
            return axios.put(`/api/universities/${slug}/workers/${userId}/deactivate`);
        }
    },
};
