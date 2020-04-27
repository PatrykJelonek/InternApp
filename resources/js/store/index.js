import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

//modules
import userStatus from "./modules/userStatus";

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    modules: {
        userStatus
    },
    strict: debug
});