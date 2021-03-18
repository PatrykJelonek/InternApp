import Vue from 'vue';
import VueRouter from 'vue-router';
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
import StudentRegistration from "../views/StudentRegistration";
import OfferCreate from "../views/OfferCreate";
import Offers from "../views/Offers";
import Offer from "../views/Offer";
import Account from "../views/Account";
import Company from "../views/Company";
import AgreementCreate from "../views/AgreementCreate";
import Agreement from "../views/Agreement";
import Internships from "../views/Internships";
import Journal from "../views/Journal";
import InternshipJournal from "../views/InternshipJournal";
import NoPermissions from "../views/NoPermissions";
import Welcome from "../views/Welcome";
import WelcomeTabs from "../components/Tabs/WelcomeTabs";
import UniversitiesTabs from "../components/Tabs/UniversitiesTabs";
import Internship from "../views/Internship";
import Profile from "../views/Profile";
import Settings from "../views/Settings";
import Notifications from "../views/Notifications";
import Messages from "../views/Messages";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/no-permissions',
            name: 'no-permissions',
            component: NoPermissions,
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
            path: '/register',
            name: 'register',
            component: Registration,
        },
        {
            path: '/register/student',
            name: 'student-registration',
            component: StudentRegistration,
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
            path: '',
            component: App,
            beforeEnter: (to, from, next) => {
                if (!store.getters['auth/authenticated']) {
                    return next({name: 'login'})
                }

                next();
            },
            children: [
                {
                    title: 'Dashboard',
                    path: '/dashboard',
                    name: 'dashboard',
                    components: {
                        default: Welcome,
                        tabs: WelcomeTabs,
                    },
                    meta: {
                        title: 'Dashboard'
                    }
                },
                {
                    path: 'users/new-status',
                    name: 'user-statuses',
                    component: UserStatusesAdd,
                },
                {
                    path: '/universities/',
                    name: 'universities',
                    components: {
                        default: Universities,
                        tabs: UniversitiesTabs
                    },
                    meta: {title: 'Uczelnia'},
                    children: [
                        {
                            path: '/universities/overview',
                            name: 'university-overview',
                            component: Companies
                        },
                        {
                            path: '/universities/internships-list',
                            name: 'university-internships-list',
                            component: Companies
                        },
                        {
                            path: '/universities/workers-list',
                            name: 'university-workers-list',
                            component: Companies
                        },
                        {
                            path: '/universities/students-list',
                            name: 'university-students-list',
                            component: Companies
                        },
                        {
                            path: '/universities/settings',
                            name: 'university-settings',
                            component: Companies
                        },
                    ],
                },
                {
                    path: '/create-university',
                    name: 'create-university',
                    component: UniversityCreate,
                },
                {
                    path: '/companies',
                    name: 'companies',
                    component: Companies,
                    meta: { have: ['admin','company_worker'], title: 'Firma'}
                },
                {
                    path: '/company/:id',
                    name: 'company',
                    component: Company,
                },
                {
                    path: '/create-company',
                    name: 'create-company',
                    component: CompanyCreate,
                },
                {
                    path: '/offers',
                    name: 'offers',
                    component: Offers,
                    meta: {title: 'Oferty Praktyk'}
                },
                {
                    path: '/offer/:id',
                    name: 'offer',
                    component: Offer,
                },
                {
                    path: '/create-offer',
                    name: 'create-offer',
                    component: OfferCreate,
                },
                {
                    path: '/create-agreement/:offerId',
                    name: 'create-agreement',
                    component: AgreementCreate,
                },
                {
                    path: '/agreement/:id',
                    name: 'agreement',
                    component: Agreement,
                },
                // {
                //     path: '/internships',
                //     name: 'internships',
                //     component: Internships,
                //     beforeEnter: (to, from, next) => {
                //         if(haveRole(['user']))
                //             return next();
                //         else
                //             return next({name: 'no-permissions'});
                //     }
                // },
                {
                    path: '/journal',
                    name: 'journal',
                    component: Journal,
                    meta: {title: 'Dziennik Praktyk'}
                },
                {
                    path: '/internship/:id/journal',
                    name: 'internship-journal',
                    component: InternshipJournal,
                },
                {
                    path: '/account',
                    name: 'account',
                    component: Account,
                },
                {
                    path: '/profile',
                    name: 'profile',
                    component: Profile,
                    meta: {title: 'Profil'},
                },
                {
                    path: '/settings',
                    name: 'setting',
                    component: Settings,
                    meta: {title: 'Ustawienia'},
                },
                {
                    path: '/notifications',
                    name: 'notifications',
                    component: Notifications,
                    meta: {title: 'Powiadomienia'},
                },
                {
                    path: '/messages',
                    name: 'messages',
                    component: Messages,
                    meta: {title: 'Wiadomości'},
                },
                {
                    path: '/internships',
                    name: 'internships',
                    component: Internships,
                    meta: {have: ['admin','student','company_worker','university_worker'], title: 'Staże i praktyki'},
                },
                {
                    path: '/internships/:internshipId',
                    name: 'internship',
                    component: Internship,
                    meta: {have: ['admin','student','company_worker','university_worker']},
                    children: [
                        {
                            path: '/internships/:internshipId/students/:studentIndex',
                            name: 'internship-student',
                            meta: {have: ['admin','student','company_worker','university_worker']},
                        }
                    ]
                }
            ],
        },
        {
            path: '*',
            name: 'not-found',
            component: NotFound
        },
    ],
});

router.beforeEach((to, from, next) => {
    const { can, have } = to.meta;
    const currentUser = store.getters['auth/user'];

    if (can || have) {
        if (!currentUser) {
            return next({ path: '/login', query: { returnUrl: to.path } });
        }

        if (have && have.length && !have.find(role => currentUser.roles.map(role => role['name']).includes(role))) {
            return next(false);
        }

        if (can && can.length && !can.find(permission => currentUser.permissions.map(permission => permission['name']).includes(permission))) {
            return next(false);
        }
    }

    next();
});

const haveRole = function (rolesToCheck) {
    let haveRole = false;

    if(store.getters['auth/roles'].length > 0)
        store.getters['auth/roles'].forEach((role) => {
            rolesToCheck.forEach((roleToCheck) => {
                if(roleToCheck === role)
                    haveRole = true;
            });
        });

    return haveRole;
};

export default router;
