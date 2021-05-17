<template>
    <v-app :style="{background: $vuetify.theme.themes[theme].background}">
        <the-app-bar-desktop v-if="!$vuetify.breakpoint.mobile"></the-app-bar-desktop>
        <!--        <the-app-bar-mobile v-else></the-app-bar-mobile>-->
        <the-app-navigation-drawer :items="menuItems"></the-app-navigation-drawer>
        <v-dialog
            v-model="menuDialog"
            fullscreen
            transition="dialog-bottom-transition"
            content-class="mt-20"
        >
            <v-card color="navBackground" class="rounded-t-lg">
                <v-container>
                    <h2 class="pl-4">Menu</h2>
                    <v-list
                        flat
                        nav
                        color="transparent"
                    >
                        <v-list-item
                            :ripple="false"
                            :to="{name: menuItem.link}"
                            active-class="primary"
                            @click="menuDialog = !menuDialog"
                            v-for="menuItem in menuItems"
                            :key="menuItem.title"
                        >
                            <v-list-item-icon>
                                <v-icon>{{ menuItem.icon }}</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>{{ menuItem.title }}</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-container>
            </v-card>
        </v-dialog>
        <v-main>
            <v-container fluid v-bind:class="fillHeight ? 'fill-height' : ''">
                <router-view></router-view>
            </v-container>
        </v-main>
        <v-bottom-navigation
            background-color="navBackground"
            class="rounded-t-lg hidden-lg-and-up"
            grow
            app
        >
            <v-btn :to="{name: 'panel'}" icon>
                <v-icon>mdi-view-dashboard</v-icon>
            </v-btn>
            <v-btn :to="{name: 'universities'}" icon>
                <v-icon>mdi-school-outline</v-icon>
            </v-btn>
            <v-btn :to="{name: 'companies'}" icon>
                <v-icon>mdi-briefcase-outline</v-icon>
            </v-btn>
            <v-btn icon @click="menuDialog=!menuDialog">
                <v-icon>mdi-dots-horizontal</v-icon>
            </v-btn>
        </v-bottom-navigation>
        <snackbar></snackbar>
    </v-app>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import TheAppBarDesktop from "../components/App/TheAppBarDesktop";
import TheAppBarMobile from "../components/App/TheAppBarMobile";
import TheAppNavigationDrawer from "../components/App/TheAppNavigationDrawer";
import Snackbar from "../components/_Helpers/Snackbar";
import TheAppBreadcrumbs from "../components/App/TheAppBreadcrumbs";

export default {
    components: {TheAppBreadcrumbs, Snackbar, TheAppNavigationDrawer, TheAppBarMobile, TheAppBarDesktop},
    data() {
        return {
            menuDialog: false,
            menuItems: [
                {text: 'Dashboard', to: {name: 'panel'}},
                {text: 'Oferty Praktyk', to: {name: 'offers'}},
                {
                    text: 'Uczelnia',
                    children: [
                        {
                            text: 'Informacje',
                            icon: 'mdi-view-dashboard-outline',
                            to: {name: 'university', params: {slug: 'panstwowa-wyzsza-szkola-zawodowa', exact: true}}
                        },
                        {
                            text: 'Umowy',
                            icon: 'mdi-file-document-multiple-outline',
                            to: {name: 'university-agreements', params: {slug: 'panstwowa-wyzsza-szkola-zawodowa'}}
                        },
                        {
                            text: 'Praktyki i Staże',
                            icon: 'mdi-certificate-outline',
                            to: {name: 'university-internships', params: {slug: 'panstwowa-wyzsza-szkola-zawodowa'}}
                        },
                        {
                            text: 'Studenci',
                            icon: 'mdi-account-supervisor',
                            to: {name: 'university-students', params: {slug: 'panstwowa-wyzsza-szkola-zawodowa'}}
                        },
                        {
                            text: 'Pracownicy',
                            icon: 'mdi-account-multiple-outline',
                            to: {name: 'university-workers', params: {slug: 'panstwowa-wyzsza-szkola-zawodowa'}}
                        },
                        {
                            text: 'Ustawienia',
                            icon: 'mdi-cog',
                            to: {name: 'university-settings', params: {slug: 'panstwowa-wyzsza-szkola-zawodowa'}}
                        },
                    ]
                },
                {
                    text: 'Firma',
                    children: [
                        {text: 'Informacje', icon: 'mdi-view-dashboard-outline', to: {name: 'company', params: {slug: 'polcom-software'}}},
                        {
                            text: 'Oferty Praktyk',
                            icon: 'mdi-newspaper-variant-multiple-outline',
                            to: {name: 'company-offers', params: {slug: 'polcom-software'}}
                        },
                        {text: 'Umowy', icon: 'mdi-file-document-multiple-outline', to: {name: 'company-agreements', params: {slug: 'polcom-software'}}},
                        {text: 'Pracownicy', icon: 'mdi-account-multiple-outline', to: {name: 'company-workers', params: {slug: 'polcom-software'}}},
                        {text: 'Ustawienia', icon: 'mdi-cog', to: {name: 'company-settings', params: {slug: 'polcom-software'}}},
                    ]
                },
                {
                    text: 'Panel Administratora',
                    children: [
                        {text: 'Dashboard', icon: 'mdi-monitor-dashboard', to: {name: 'admin'}},
                        {text: 'Statystyki', icon: 'mdi-chart-box-outline', to: {name: 'admin-statistics'}},
                        {text: 'Użytkownicy', icon: 'mdi-account-group-outline', to: {name: 'admin-users'}},
                        {
                            text: 'Oferty Praktyk',
                            icon: 'mdi-newspaper-variant-multiple-outline',
                            children: [
                                {text: 'Do Akceptacji', to: {name: 'admin-offers', query: {categories: ['new']}}},
                                {text: 'Wszystkie', to: {name: 'admin-offers'}}
                            ]
                        },
                        {text: 'Ustawienia', icon: 'mdi-application-cog', to: {name: 'admin-settings'}},
                    ]
                }
            ]
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
