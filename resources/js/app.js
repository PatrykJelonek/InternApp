import '@fortawesome/fontawesome-free/css/all.css';
import '@fortawesome/fontawesome-free/js/all.js';
import store from './store';
import vuetify from "./plugins/vuetify";
import axios from 'axios';

require('./bootstrap');
window.Vue = require('vue');

import SideMenu from './components/SideMenu.vue';
import SideMenuItem from './components/SideMenuItem.vue';
import UserStatuses from './components/UserStatuses.vue';
import UserStatusesAdd from "./components/UserStatusesAdd";
import HelloVuetify from "./components/HelloVuetify";

Vue.component('side-menu', SideMenu);
Vue.component('side-menu-item', SideMenuItem);
Vue.component('user-statuses', UserStatuses);
Vue.component('user-status-add', UserStatusesAdd);
Vue.component('HelloVuetify', HelloVuetify)

new Vue({
    store,
    vuetify
}).$mount('#app');
