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

const isTrue = true;

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            redirect: to => {
                if (isTrue)
                    return {name: 'dashboard'};
                else
                    return {name: 'sign-in'};
            }
        },
        {
            path: '/sign-in',
            name: 'sign-in',
            component: SignIn
        },
        {
            path: '/sign-up',
            name: 'sign-up',
            component: Registration,
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
            children: [
                {
                    path: 'users/new-status',
                    name: 'user-statuses',
                    component: UserStatusesAdd
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
