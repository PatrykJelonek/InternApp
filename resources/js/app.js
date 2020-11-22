import '@fortawesome/fontawesome-free/css/all.css';
import '@fortawesome/fontawesome-free/js/all.js';
import store from './store';
import vuetify from "./plugins/vuetify";
import Routes from './router/routers';

require('./bootstrap');
require('./store/subscriber');
require('./plugins/acl');
window.Vue = require('vue');

store.dispatch('auth/attempt', localStorage.getItem('token')).then(() => {
    new Vue({
        el: '#app',
        router: Routes,
        store,
        vuetify
    });
});


