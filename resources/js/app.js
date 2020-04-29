import '@fortawesome/fontawesome-free/css/all.css';
import '@fortawesome/fontawesome-free/js/all.js';
import store from './store';
import vuetify from "./plugins/vuetify";
import Routes from './router/routers';
import axios from 'axios';

require('./bootstrap');
window.Vue = require('vue');

import App from "./views/App";

new Vue({
    el: '#app',
    router: Routes,
    store,
    vuetify
});
