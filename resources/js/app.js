import '@fortawesome/fontawesome-free/css/all.css';
import '@fortawesome/fontawesome-free/js/all.js';
import store from './store';
import axios from 'axios';

require('./bootstrap');
window.Vue = require('vue');

import SideMenu from './components/SideMenu.vue';
import SideMenuItem from './components/SideMenuItem.vue';
import UserStatuses from './components/UserStatuses.vue';
import UserStatusesAdd from "./components/UserStatusesAdd";

Vue.component('side-menu', SideMenu);
Vue.component('side-menu-item', SideMenuItem);
Vue.component('user-statuses', UserStatuses);
Vue.component('user-status-add', UserStatusesAdd);

new Vue({
    el: '#app',
    store
});
