import Vue from 'vue';
import Vuetify from "vuetify";
import 'vuetify/dist/vuetify.min.css';

Vue.use(Vuetify);

export default new Vuetify({
    theme: {
        options: {
            customProperties: true,
        },
        themes: {
            light: {
                primary: '#2757FF',
                background: '#f7f7fa',
                navigationDrawerExpanded: '#efeff5',
            },
        },
    },
});
