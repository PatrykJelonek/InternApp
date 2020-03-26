import '@fortawesome/fontawesome-free/css/all.css';
import '@fortawesome/fontawesome-free/js/all.js'

require('./bootstrap');
window.Vue = require('vue');

import Welcome from './components/Welcome.vue';
import Patryk from './components/Patryk.vue';
import SideMenu from './components/SideMenu.vue';
import SideMenuItem from './components/SideMenuItem.vue';

Vue.component('welcome', Welcome);
Vue.component('patryk', Patryk);
Vue.component('side-menu', SideMenu);
Vue.component('side-menu-item', SideMenuItem);

new Vue({
    el: '#app'
});
