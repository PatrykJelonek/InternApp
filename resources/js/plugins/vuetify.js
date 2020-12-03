import Vue from 'vue';
import Vuetify from "vuetify";
import 'vuetify/dist/vuetify.min.css';

Vue.use(Vuetify);

export default new Vuetify({
    theme: {
        themes: {
            light: {
                'primary': '#2b2d42',
                'secondary': '#ef233c',
                'secondary-dark': '#d90429',
                'accent': '',
                'accent-light': '',
                'accent-dark': '',
                'light': '#edf2f4',
                'light-dark': '#8d99ae',
                'light-light': '#fff',
                error: '#FF5252',
                info: '#2196F3',
                success: '#4CAF50',
                warning: '#FFC107',
            },
        },
    },
});
