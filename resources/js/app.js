import '@fortawesome/fontawesome-free/css/all.css';
import '@fortawesome/fontawesome-free/js/all.js';
import store from './store';
import vuetify from "./plugins/vuetify";
import Routes from './router/routers';
import axios from 'axios';

require('./bootstrap');
require('./store/subscriber');
window.Vue = require('vue');

import App from "./views/App";

store.dispatch('auth/attempt', localStorage.getItem('token')).then(() => {
    new Vue({
        el: '#app',
        router: Routes,
        store,
        vuetify
    });
});


