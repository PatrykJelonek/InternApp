import '@fortawesome/fontawesome-free/css/all.css';
import '@fortawesome/fontawesome-free/js/all.js';
import store from './store';
import vuetify from "./plugins/vuetify";
import Routes from './router/routers';
import 'clockwork-browser/metrics';
import Vue from 'vue';
import * as Sentry from "@sentry/vue";
import {Integrations} from "@sentry/tracing";
import {CaptureConsole} from "@sentry/integrations";
import moment from "moment";
import { VueMaskDirective } from 'v-mask';

require('./bootstrap');
require('./store/subscriber');
require('./plugins/acl');
window.Vue = require('vue');

Vue.directive('mask', VueMaskDirective);

Sentry.init({
    Vue,
    dsn: "https://0f45f8de5b1a421c8edc02c0cba67452@o523467.ingest.sentry.io/5636397",
    integrations: [
        new Integrations.BrowserTracing(),
        new CaptureConsole({levels: ['error']})
    ],
    logErrors: true,
    // We recommend adjusting this value in production, or using tracesSampler
    // for finer control
    tracesSampleRate: 1.0,
    tracingOptions: {
        trackComponents: true,
    },
});

var dateMethods = {
    methods: {}
};

moment.locale('pl');
Vue.prototype.moment = moment;

// Set default theme in localStorage
if (localStorage.getItem('THEME') === undefined) {
    localStorage.setItem('THEME', 'light');
}

store.dispatch('auth/attempt', localStorage.getItem('token')).then(() => {
    new Vue({
        el: '#app',
        router: Routes,
        mixin: [''],
        store,
        vuetify,
    });
});


