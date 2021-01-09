<template>
    <v-app>
        <v-navigation-drawer
            app
            floating
            :mobile-breakpoint="$vuetify.breakpoint.xs ? 'xs' : 'sm'"
            v-model="navigationDrawer.drawer"
            :mini-variant="navigationDrawer.miniVariant && $vuetify.breakpoint.mdAndUp"
            :color="navigationDrawer.miniVariant && $vuetify.breakpoint.mdAndUp ? 'transparent' : ' navigationDrawerExpanded'"
        >
            <v-list nav dense>
                <v-list-item-group active-class="primary--text primary--darken-1" v-model="navigationDrawer.group">
                    <v-list-item link to="/" dense>
                        <v-list-item-icon>
                            <v-icon dense>mdi-view-dashboard</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Dashboard</v-list-item-title>
                    </v-list-item>
                </v-list-item-group>

                <v-list-item-group class="mt-1" active-class="primary--text primary--darken-1">
                    <v-subheader
                        v-bind:class="{'hidden': navigationDrawer.miniVariant}"
                        class="caption font-weight-medium text-uppercase"
                    >
                        Ogólne
                    </v-subheader>
                    <v-list-item link to="universities" dense>
                        <v-list-item-icon>
                            <v-icon dense>mdi-school-outline</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Uczelnia</v-list-item-title>
                    </v-list-item>
                    <v-list-item link to="companies" dense>
                        <v-list-item-icon>
                            <v-icon dense>mdi-briefcase-outline</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Firma</v-list-item-title>
                    </v-list-item>
                    <v-list-item link to="offers" dense>
                        <v-list-item-icon>
                            <v-icon dense>mdi-format-list-bulleted</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Oferty Praktyk</v-list-item-title>
                    </v-list-item>
                </v-list-item-group>

                <v-subheader class="hidden hidden-md-and-up"></v-subheader>

                <v-list-group
                    no-action
                    prepend-icon="mdi-account"
                    class="mt-1 hidden-md-and-up"
                    active-class="primary--text primary--darken-1"
                >
                    <template v-slot:activator>
                        <v-list-item-title>Konto</v-list-item-title>
                    </template>
                    <v-list-item link dense>
                        <v-list-item-title>Profil</v-list-item-title>
                    </v-list-item>
                    <v-list-item link dense>
                        <v-list-item-title>Ustawienia</v-list-item-title>
                    </v-list-item>
                    <v-list-item link dense>
                        <v-list-item-title>Wyloguj</v-list-item-title>
                    </v-list-item>
                </v-list-group>
            </v-list>
            <template v-slot:append>
                <v-list nav>
                    <v-list-item
                        dense
                        active-class="none"
                        class="hidden-sm-and-down"
                        @click.stop="navigationDrawer.miniVariant = !navigationDrawer.miniVariant"
                    >
                        <v-list-item-icon>
                            <v-icon dense v-if="navigationDrawer.miniVariant">mdi-chevron-right</v-icon>
                            <v-icon dense v-else>mdi-chevron-left</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Ukryj menu</v-list-item-title>
                    </v-list-item>
                </v-list>
            </template>
        </v-navigation-drawer>

        <v-app-bar app flat dense color="background" class="px-5">
            <!--            <v-app-bar-nav-icon v-if="$vuetify.breakpoint.smAndUp" @click.stop="navigationDrawer.drawer = !navigationDrawer.drawer"></v-app-bar-nav-icon>-->
            <v-toolbar-title class="font-weight-bold">Intern</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-badge color="error" dot overlap bordered class="hidden-xs-only">
                <v-btn icon small class="ml-5">
                    <v-icon dense>mdi-bell-outline</v-icon>
                </v-btn>
            </v-badge>
            <v-badge color="error" dot overlap bordered class="hidden-xs-only">
                <v-btn icon small class="ml-5">
                    <v-icon dense>mdi-email-outline</v-icon>
                </v-btn>
            </v-badge>
            <v-menu left bottom offset-y nudge-bottom="10">
                <template v-slot:activator="{ on, attrs }">
                    <v-btn text v-on="on" v-bind="attrs" class="ml-5 hidden-sm-and-down">
                        {{user.first_name + " " + user.last_name}}
                        <v-icon class="ml-3">mdi-chevron-down</v-icon>
                    </v-btn>
                </template>
                <v-list nav dense>
                    <v-list-item link dense>
                        <v-list-item-icon>
                            <v-icon dense>mdi-account</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Profil</v-list-item-title>
                    </v-list-item>
                    <v-list-item link dense>
                        <v-list-item-icon>
                            <v-icon dense>mdi-cog</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Ustawienia</v-list-item-title>
                    </v-list-item>
                    <v-list-item link dense>
                        <v-list-item-icon>
                            <v-icon dense>mdi-logout-variant</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Wyloguj</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
            <v-app-bar-nav-icon
                class="ml-3"
                v-if="$vuetify.breakpoint.smAndDown"
                @click.stop="navigationDrawer.drawer = !navigationDrawer.drawer"
            ></v-app-bar-nav-icon>
        </v-app-bar>

        <v-main>
            <v-container fluid class="px-6">
                <router-view></router-view>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
    import {mapGetters} from "vuex";
    import Sidebar from "../components/_Helpers/Sidebar";

    export default {
        components: {Sidebar},
        data() {
            return {
                navigationDrawer: {
                    drawer: null,
                    miniVariant: true,
                    group: null,
                }
            }
        },

        computed: {
            ...mapGetters({
                user: 'auth/user',
            }),
        },

        watch: {
            group () {
                this.drawer = false
            },
        },
    }
</script>

<style lang="scss">
    #app {
        background-color: #f7f7fa;
        font-family: 'Montserrat', sans-serif;
    }

    .v-expansion-panel-content__wrap {
        padding: 0 !important;
    }

    .hidden {
        opacity: 0;
    }

</style>
