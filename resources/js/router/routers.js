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

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/no-permissions',
            name: 'no-permissions',
            component: NoPermissions,
        },
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
                    component: UserStatusesAdd,
                },
                {
                    path: '/universities',
                    name: 'universities',
                    component: Universities,
                    beforeEnter: (to, from, next) => {
                        if(!haveRole(['student']))
                            return next();
                        else
                            return next({name: 'no-permissions'});
                    }
                },
                {
                    path: '/create-university',
                    name: 'create-university',
                    component: UniversityCreate,
                    beforeEnter: (to, from, next) => {
                        if(!haveRole(['student']))
                            return next();
                        else
                            return next({name: 'no-permissions'});
                    }
                },
                {
                    path: '/companies',
                    name: 'companies',
                    component: Companies,
                    beforeEnter: (to, from, next) => {
                        if(!haveRole(['student']))
                            return next();
                        else
                            return next({name: 'no-permissions'});
                    }
                },
                {
                    path: '/company/:id',
                    name: 'company',
                    component: Company,
                    beforeEnter: (to, from, next) => {
                        if(!haveRole(['student']))
                            return next();
                        else
                            return next({name: 'no-permissions'});
                    }
                },
                {
                    path: '/create-company',
                    name: 'create-company',
                    component: CompanyCreate,
                    beforeEnter: (to, from, next) => {
                        if(!haveRole(['student']))
                            return next();
                        else
                            return next({name: 'no-permissions'});
                    }
                },
                {
                    path: '/offers',
                    name: 'offers',
                    component: Offers,
                    beforeEnter: (to, from, next) => {
                        if(!haveRole(['student']))
                            return next();
                        else
                            return next({name: 'no-permissions'});
                    }
                },
                {
                    path: '/offer/:id',
                    name: 'offer',
                    component: Offer,
                    beforeEnter: (to, from, next) => {
                        if(!haveRole(['student']))
                            return next();
                        else
                            return next({name: 'no-permissions'});
                    }
                },
                {
                    path: '/create-offer',
                    name: 'create-offer',
                    component: OfferCreate,
                    beforeEnter: (to, from, next) => {
                        if(haveRole(['company-worker']))
                            return next();
                        else
                            return next({name: 'no-permissions'});
                    }
                },
                {
                    path: '/create-agreement/:offerId',
                    name: 'create-agreement',
                    component: AgreementCreate,
                    beforeEnter: (to, from, next) => {
                        if(haveRole(['university-worker']))
                            return next();
                        else
                            return next({name: 'no-permissions'});
                    }
                },
                {
                    path: '/agreement/:id',
                    name: 'agreement',
                    component: Agreement,
                    beforeEnter: (to, from, next) => {
                        if(!haveRole(['student']))
                            return next();
                        else
                            return next({name: 'no-permissions'});
                    }
                },
                {
                    path: '/internships',
                    name: 'internships',
                    component: Internships,
                    beforeEnter: (to, from, next) => {
                        if(haveRole(['user']))
                            return next();
                        else
                            return next({name: 'no-permissions'});
                    }
                },
                {
                    path: '/journal',
                    name: 'journal',
                    component: Journal,
                    beforeEnter: (to, from, next) => {
                        if(haveRole(['student']))
                            return next();
                        else
                            return next({name: 'no-permissions'});
                    }
                },
                {
                    path: '/internship/:id/journal',
                    name: 'internship-journal',
                    component: InternshipJournal,
                    beforeEnter: (to, from, next) => {
                        if(!haveRole(['student']))
                            return next();
                        else
                            return next({name: 'no-permissions'});
                    }
                },
                {
                    path: '/account',
                    name: 'account',
                    component: Account,
                    beforeEnter: (to, from, next) => {
                        if(haveRole(['user']))
                            return next();
                        else
                            return next({name: 'no-permissions'});
                    }
                }
            ],
        },
        {
            path: '*',
            component: NotFound
        },
    ],
});

const haveRole = function (rolesToCheck) {
    let haveRole = false;

    if(store.getters['auth/roles'].length > 0)
        store.getters['auth/roles'].forEach((role) => {
            rolesToCheck.forEach((roleToCheck) => {
                console.log(`${roleToCheck} vs. ${role} == ${roleToCheck === role}`);
                if(roleToCheck === role)
                    haveRole = true;
            });
        });

    return haveRole;
};

export default router;
