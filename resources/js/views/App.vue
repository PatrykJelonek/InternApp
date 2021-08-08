<template>
    <v-app :style="{background: $vuetify.theme.themes[theme].background}">
        <!-- Horizontal Menu -->
        <the-app-bar-desktop v-if="!$vuetify.breakpoint.mobile"></the-app-bar-desktop>

        <!-- Vertical Menu -->
        <the-app-navigation-drawer></the-app-navigation-drawer>

        <!-- Website Main Content -->
        <v-main>
            <v-container fluid v-bind:class="this.$vuetify.breakpoint.mdAndDown ? 'px-2 py-5' : 'px-15 py-10'">
                <router-view></router-view>
            </v-container>
        </v-main>

        <!-- Snackbar Instance -->
        <snackbar></snackbar>

        <!-- Bottom menu -->
        <the-app-bottom-menu v-if="$vuetify.breakpoint.mobile"></the-app-bottom-menu>
    </v-app>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import TheAppBarDesktop from "../components/App/TheAppBarDesktop";
import TheAppNavigationDrawer from "../components/App/TheAppNavigationDrawer";
import Snackbar from "../components/_Helpers/Snackbar";
import TheAppBottomMenu from "../components/App/TheAppBottomMenu";

export default {
    components: {TheAppBottomMenu, Snackbar, TheAppNavigationDrawer, TheAppBarDesktop},
    data() {
        return {
            menuDialog: false,
        }
    },

    methods: {
        ...mapActions({
            setSnackbar: 'snackbar/setSnackbar'
        }),
    },

    computed: {
        ...mapGetters({
            user: 'auth/user',
            fillHeight: 'helpers/fillHeight',
        }),

        theme() {
            return (this.$vuetify.theme.dark) ? 'dark' : 'light'
        }
    },

    created() {
        this.$vuetify.theme.dark = localStorage.getItem('THEME') === 'dark';
    },

    watch: {
        group() {
            this.drawer = false
        },
    },
}
</script>

<style lang="scss">
body {
    // background-color: #0F1115;
}

#app {
    //background-color: #0F1115;
    font-family: 'Montserrat', sans-serif;
}

.v-expansion-panel-content__wrap {
    padding: 0 !important;
}

.hidden {
    opacity: 0;
}

.mt-20 {
    margin-top: 20% !important;
}

.font-m {
    font-family: 'Montserrat', sans-serif !important;
}
</style>
