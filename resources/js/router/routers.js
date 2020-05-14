import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

//Components imports
import HelloVuetify from "../components/HelloVuetify";
import UserStatusesAdd from "../components/UserStatusesAdd";
import SignIn from "../views/SignIn";
import SignUp from "../views/SignUp_Old";
import Registration from "../views/Registration";
import App from "../views/App";
import NotFound from "../views/NotFound";
import SingUpStudent from "../components/SingUpStudent";
import SignUpCompany from "../components/SignUpCompany";
import SignUpUniversity from "../components/SignUpUniversity";

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
            children: [
                {
                    path: 'student',
                    name: 'student-sign-up',
                    component: SingUpStudent
                },
                {
                    path: 'company',
                    name: 'company-sign-up',
                    component: SignUpCompany
                },
                {
                    path: 'university',
                    name: 'university-sign-up',
                    component: SignUpUniversity
                }
            ]
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
