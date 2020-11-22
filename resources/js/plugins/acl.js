import Vue from 'vue';
import store from "../store";

Vue.directive('has', {
    inserted: function (el,binding, vnode) {
        if(!has(binding.value)) {
            vnode.elm.parentElement.removeChild(vnode.elm);
        }
    },
});

Vue.directive('can', {
    inserted: function (el,binding, vnode) {
        if(!can(binding.value)) {
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
