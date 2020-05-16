import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

//Components imports
import UserStatusesAdd from "../components/UserStatusesAdd";
import SignIn from "../views/SignIn";
import Registration from "../views/Registration";
import App from "../views/App";
import NotFound from "../views/NotFound";
import Rules from "../views/Rules";
import Universities from "../views/Universities";
import Companies from "../views/Companies";

import store from "../store/index";
import Login from "../views/Login";

const isTrue = false;

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            redirect: '/dashboard'
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
            beforeEnter: (to, from, next) => {
                const loggedIn = localStorage.getItem('user');

                if(loggedIn) next({name: 'dashboard'});
                else next();
            },
        },
        {
            path: '/sign-up',
            name: 'sign-up',
            component: Registration,
        },
        {
            path: '/logout',
            name: 'logout',
            beforeEnter: (to, from, next) => {
              store.dispatch('logoutUser');
              next({name: 'login'});
            },
        },
        {
            path: '/rules',
            name: 'rules',
            component: Rules,
        },
        {
            path: '/dashboard',
            name: 'dashboard',
            component: App,
            beforeEnter: (to, from, next) => {
                const loggedIn = localStorage.getItem('user');

                if(!loggedIn) next({name: 'login'});
                else next();
            },
            children: [
                {
                    path: 'users/new-status',
                    name: 'user-statuses',
                    component: UserStatusesAdd
                },
                {
                    path: '/universities',
                    name: 'universities',
                    component: Universities
                },
                {
                    path: '/companies',
                    name: 'companies',
                    component: Companies
                }
            ],
        },
        {
            path: '*',
            component: NotFound
        }
    ],
});

export default router;
