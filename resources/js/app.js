require('./bootstrap');
window.Vue = require('vue');

import Welcome from './components/Welcome.vue';
import Patryk from './components/Patryk.vue';
import Menu from './components/Menu.vue';

Vue.component('welcome', Welcome);
Vue.component('patryk', Patryk);
Vue.component('navigation', Menu);

new Vue({
    el: '#app'
});
