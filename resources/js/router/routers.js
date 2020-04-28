import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

//Components imports
import HelloVuetify from "../components/HelloVuetify";
import UserStatusesAdd from "../components/UserStatusesAdd";

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: HelloVuetify
        },
        {
            path: '/add-user-status',
            name: 'addUserStatus',
            component: UserStatusesAdd
        }
    ],
});

export default router;
