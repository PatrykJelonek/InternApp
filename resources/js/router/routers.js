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
import University from "../views/University"
import Test from "../views/Test";
import TheUniversityOverview from "../components/University/Overview/TheUniversityOverview";
import TheUniversityStudents from "../components/University/Students/TheUniversityStudents";
import TheUniversityWorkers from "../components/University/Workers/TheUniversityWorkers";
import TheUniversityAgreements from "../components/University/Agreements/TheUniversityAgreements";
import TheUniversityInternships from "../components/University/Internships/TheUniversityInternships";
import TheUniversitySettings from "../components/University/Settings/TheUniversitySettings";
import StudentOffersList from "../components/Offers/Student/StudentOffersList";
import TheStudentOfferApplicationsList from "../components/Offers/Student/TheStudentOfferApplicationsList";
import TheStudentOffers from "../components/Offers/Student/TheStudentOffers";
import LandingPage from "../views/LandingPage";
import Admin from "../views/Admin";
import TheAdminOffers from "../components/Admin/Offers/TheAdminOffers";
import TheAdminStatistics from "../components/Admin/Statistics/TheAdminStatistics";
import TheAdminUsers from "../components/Admin/Users/TheAdminUsers";
import TheCompanyOverview from "../components/Company/Overview/TheCompanyOverview";
import TheCompanyOffers from "../components/Company/Offers/TheCompanyOffers";
import TheCompanyAgreements from "../components/Company/Agreements/TheCompanyAgreements";
import TheCompanyWorkers from "../components/Company/Workers/TheCompanyWorkers";
import TheCompanySettings from "../components/Company/Settings/TheCompanySettings";
import TheAdminSettings from "../components/Admin/Settings/TheAdminSettings";
import OffersList from "../components/Offers/OffersList";
import OffersLists from "../components/Offers/OffersLists";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/test',
            name: 'test',
            component: Test,
            meta: {title: 'Wiadomości'},
        },
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
            name: 'landing-page',
            component: LandingPage,
        },
        {
            title: 'Dashboard',
            path: '/dashboard',
            beforeEnter: (to, from, next) => {
                if (!store.getters['auth/authenticated']) {
                    return next({name: 'login'})
                }

                next();
            },
            components: {
                default: App,
            },
            meta: {
                title: 'Dashboard'
            },
            children: [
                {
                    path: '/dashboard/',
                    name: 'dashboard',
                    component: Welcome
                },
                {
                    path: 'users/new-status',
                    name: 'user-statuses',
                    component: UserStatusesAdd,
                },
                {
                    path: '/dashboard/universities/',
                    name: 'universities',
                    components: {
                        default: Universities,
                    },
                    meta: {title: 'Uczelnia'},
                },
                {
                    path: '/create-university',
                    name: 'create-university',
                    component: UniversityCreate,
                },
                {
                    path: '/dashboard/companies',
                    name: 'companies',
                    component: Companies,
                    meta: { have: ['admin','company_worker','company_owner'], title: 'Firma'}
                },
                {
                    path: '/dashboard/companies/:slug',
                    component: Company,
                    children: [
                        {
                            path: '/dashboard/companies/:slug/',
                            name: 'company',
                            component: TheCompanyOverview,
                        },
                        {
                            path: '/dashboard/companies/:slug/offers',
                            name: 'company-offers',
                            component: TheCompanyOffers
                        },
                        {
                            path: '/dashboard/companies/:slug/agreements',
                            name: 'company-agreements',
                            component: TheCompanyAgreements
                        },
                        {
                            path: '/dashboard/companies/:slug/workers',
                            name: 'company-workers',
                            component: TheCompanyWorkers
                        },
                        {
                            path: '/dashboard/companies/:slug/settings',
                            name: 'company-settings',
                            component: TheCompanySettings
                        },
                    ]
                },

                {
                    path: '/dashboard/universities/:slug',
                    component: University,
                    children: [
                        {
                            path: '/dashboard/universities/:slug/',
                            name: 'university',
                            component: TheUniversityOverview,
                        },
                        {
                            path: 'students',
                            name: 'university-students',
                            component: TheUniversityStudents
                        },
                        {
                            path: 'workers',
                            name: 'university-workers',
                            component: TheUniversityWorkers
                        },
                        {
                            path: 'agreements',
                            name: 'university-agreements',
                            component: TheUniversityAgreements
                        },
                        {
                            path: 'internships',
                            name: 'university-internships',
                            component: TheUniversityInternships
                        },
                        {
                            path: 'settings',
                            name: 'university-settings',
                            component: TheUniversitySettings
                        }
                    ]
                },
                {
                    path: '/create-company',
                    name: 'create-company',
                    component: CompanyCreate,
                },
                {
                    path: '/dashboard/offers',
                    component: Offers,
                    meta: {title: 'Oferty Praktyk'},
                    children: [
                        {
                            path: '',
                            name: 'offers',
                            meta: {title: 'Oferty Praktyk'},
                            component: OffersLists
                        },
                        {
                            path: 'applications',
                            name: 'internship-applications',
                            meta: {title: 'Aplikacje na Praktyki'},
                            component: TheStudentOfferApplicationsList
                        }
                    ]
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
                    path: '/dashboard/offers/:slug',
                    name: 'offer',
                    component: Offer,
                },
                {
                    path: '/dashboard/agreements/:slug',
                    name: 'agreement',
                    component: Agreement,
                },
                {
                    path: '/dashboard/account',
                    name: 'account',
                    component: Account,
                },
                {
                    path: '/dashboard/users/:id',
                    name: 'user',
                    component: Profile,
                    meta: {title: 'Profil'},
                },
                {
                    path: '/dashboard/settings',
                    name: 'setting',
                    component: Settings,
                    meta: {title: 'Ustawienia'},
                },
                {
                    path: '/dashboard/notifications',
                    name: 'notifications',
                    component: Notifications,
                    meta: {title: 'Powiadomienia'},
                },
                {
                    path: '/dashboard/messages',
                    name: 'messages',
                    component: Messages,
                    meta: {title: 'Wiadomości'},
                },
                {
                    path: '/dashboard/internships',
                    name: 'internships',
                    component: Internships,
                    meta: {have: ['admin','student','company_worker','university_worker'], title: 'Staże i praktyki'},
                },
                {
                    path: '/dashboard/internships/:internshipId',
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
                },
                {
                    path: '/dashboard/admin',
                    component: Admin,
                    meta: {have: ['admin']},
                    children: [
                        {
                            path: '/dashboard/admin/statistics',
                            name: 'admin',
                            component: TheAdminStatistics,
                            meta: {have: ['admin']},
                        },
                        {
                            path: '/dashboard/admin/offers',
                            name: 'admin-offers',
                            component: TheAdminOffers,
                            meta: {have: ['admin']},
                        },
                        {
                            path: '/dashboard/admin/users',
                            name: 'admin-users',
                            component: TheAdminUsers,
                            meta: {have: ['admin']},
                        },
                        {
                            path: '/dashboard/admin/settings',
                            name: 'admin-settings',
                            component: TheAdminSettings,
                            meta: {have: ['admin']},
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

const hasRole = function (rolesToCheck) {
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
