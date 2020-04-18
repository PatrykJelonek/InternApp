import '@fortawesome/fontawesome-free/css/all.css';
import '@fortawesome/fontawesome-free/js/all.js'
import axios from 'axios';

require('./bootstrap');
window.Vue = require('vue');

import SideMenu from './components/SideMenu.vue';
import SideMenuItem from './components/SideMenuItem.vue';
import UserStatuses from './components/UserStatuses.vue';

Vue.component('side-menu', SideMenu);
Vue.component('side-menu-item', SideMenuItem);
Vue.component('user-statuses', UserStatuses);

new Vue({
    el: '#app'
});
