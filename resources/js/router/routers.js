import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

//Other imports
import store from "../store/index";

//Components imports
import UserStatusesAdd from "../components/UserStatusesAdd";
import Registration from "../views/Registration";
import App from "../views/App";
import NotFound from "../views/NotFound";
import Rules from "../views/Rules";
import Universities from "../views/Universities";
import Companies from "../views/Companies";
import Login from "../views/Login";
import UniversityCreate from "../views/UniversityCreate";
import CompanyCreate from "../views/CompanyCreate";

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
                if (store.getters['auth/authenticated']) {
                    return next({
                        name: 'dashboard'
                    });
                }

                return next();
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
               store.dispatch('auth/signOut').then(() =>{
                   return next({name: 'login'})
               })

                return next();
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
                if (!store.getters['auth/authenticated']) {
                    return next({name: 'login'})
                }

                next();
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
                    component: Universities,
                },
                {
                    path: '/create-university',
                    name: 'create-university',
                    component: UniversityCreate
                },
                {
                    path: '/companies',
                    name: 'companies',
                    component: Companies
                },
                {
                    path: '/create-company',
                    name: 'create-company',
                    component: CompanyCreate
                },
            ],
        },
        {
            path: '*',
            component: NotFound
        }
    ],
});

export default router;
