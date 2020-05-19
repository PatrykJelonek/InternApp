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

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    modules: {
        company,
        auth,
        userStatus,
        university,
        user,
        city,
    },
    strict: debug
});
