import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

//modules
import userStatus from "./modules/userStatus";
import university from "./modules/university";
import user from "./modules/user";
import auth from "./modules/auth";
import city from "./modules/city";
import company from "./modules/company";
import snackbar from "./modules/snackbar";
import specialization from "./modules/specialization";
import faculty from "./modules/faculty";
import field from "./modules/field";
import student from "./modules/student";
import offer from "./modules/offer";
import agreement from "./modules/agreement";

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    modules: {
        company,
        auth,
        userStatus,
        university,
        user,
        city,
        snackbar,
        specialization,
        faculty,
        field,
        student,
        offer,
        agreement
    },
    strict: debug
});
