import Vue from 'vue';
import Vuetify from "vuetify";
import 'vuetify/dist/vuetify.min.css';

Vue.use(Vuetify);

export default new Vuetify({
    theme: {
        dark: true,
        options: {
            customProperties: true,
        },
        themes: {
            light: {
                //primary: '#2757FF',
                primary: '#00C853',
                secondary: '#9DA0A5',
                //background: '#f7f7fa',
                navigationDrawerExpanded: '#efeff5',
                'base-background': '#E5E6E8',
                background: '#E5E6E8',
                'component-background': '#FFF',
                'tooltip-background': '#181A20',
                'card-background': '#fff'
            },
            dark: {
                //primary: '#1976D2',
                primary: '#00C853',
                secondary: '#9DA0A5',
                accent: '#82B1FF',
                error: '#FF5252',
                info: '#2196F3',
                success: '#4CAF50',
                warning: '#FFC107',
                background: '#0F1115',
                navBackground: '#181A20',
                cardBackground: '#181A20',
                'base-background': '#0F1115',
                'component-background': '#181A20',
                'tooltip-background': '#181A20',
                'card-background': '#181A20',
            }
        },
    },
});
