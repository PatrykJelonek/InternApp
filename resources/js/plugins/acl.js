import Vue from 'vue';
import store from "../store";

Vue.directive('has', {
    inserted: function (el, binding, vnode) {
        if (!has(binding.value)) {
            vnode.elm.parentElement.removeChild(vnode.elm);
        }
    },
});

Vue.directive('can', {
    inserted: function (el, binding, vnode) {
        if (!can(binding.value)) {
            vnode.elm.parentElement.removeChild(vnode.elm);
        }
    },
});

Vue.directive('hasUniversityRole', {
    inserted: function (el, binding, vnode) {
        if (!hasUniversityRole(binding.value)) {
            vnode.elm.parentElement.removeChild(vnode.elm);
        }
    },
});

Vue.directive('hasCompanyRole', {
    inserted: function (el, binding, vnode) {
        if (!hasCompanyRole(binding.value)) {
            vnode.elm.parentElement.removeChild(vnode.elm);
        }
    },
});

const can = (permissions) => {
    const currentUser = store.getters['auth/user'];

    if (permissions) {
        if (!currentUser) return false;
        if (permissions.length && !permissions.find(permission => currentUser.permissions.map(permission => permission['name']).includes(permission))) return false;
    }

    return true;
}

const has = function (roles) {
    const currentUser = store.getters['auth/user'];

    if (roles) {
        if (!currentUser) return false;
        if (roles.length && !roles.find(role => currentUser.roles.map(role => role['name']).includes(role))) return false;
    }

    return true;
};

export const hasUniversityRole = function (roles, allowEmpty = false) {
    const currentUser = store.getters['auth/user'];
    let currentUniversity = store.getters['university/university'];
    console.log(currentUniversity.id);
    // if (!currentUniversity) {
    //     let universityFromStorage = JSON.parse(localStorage.getItem('SELECTED_UNIVERSITY'));
    //
    //     if (universityFromStorage) {
    //         store.commit( 'university/SET_UNIVERSITY', [universityFromStorage]);
    //         console.log('2222s');
    //         currentUniversity = store.getters['university/university'];
    //     } else if (currentUser.universities.length > 0) {
    //         store.dispatch('university/fetchUniversity', [currentUser.universities[0].slug]);
    //         console.log('asdasd');
    //         currentUniversity = store.getters['university/university'];
    //     }
    // }

    if (roles) {
        if (!currentUser || !currentUser.universities_with_roles || !currentUniversity || roles.length < 1) return false;
        let hasRole = false;

        currentUser.universities_with_roles.forEach((universityWithRoles) => {
            if (universityWithRoles.university_id === currentUniversity.id) {
                roles.forEach(role => {
                    hasRole = hasRole ? true : universityWithRoles.roles.map(role => role['name']).includes(role);
                });
            }
        });

        return hasRole;
    }

    return allowEmpty;
};

export const hasCompanyRole = function (roles, allowEmpty = false) {
    const currentUser = store.getters['auth/user'];
    const currentCompany = store.getters['company/company'];

    if (roles) {
        if (!currentUser || !currentUser.companies_with_roles || !currentCompany || roles.length < 1) return false;
        let hasRole = false;

        currentUser.companies_with_roles.forEach((companyWithRoles) => {
            if (companyWithRoles.company_id === currentCompany.id) {
                roles.forEach(role => {
                    hasRole = hasRole ? true : companyWithRoles.roles.map(role => role['name']).includes(role);
                });
            }
        });

        return hasRole;
    }

    return allowEmpty;
};
