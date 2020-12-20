<template>
    <v-app>
        <v-navigation-drawer
            app
            floating
            :color="navigationDrawer.miniVariant ? 'transparent' : ' navigationDrawerExpanded'"
            :mini-variant="navigationDrawer.miniVariant"
            :permanent="navigationDrawer.permanent"
        >
            <v-list nav dense>
                <v-list-item-group active-class="primary--text primary--darken-1">
                    <v-list-item
                        dense
                        active-class="none"
                        @click.stop="navigationDrawer.miniVariant = !navigationDrawer.miniVariant"
                    >
                        <v-list-item-icon>
                            <v-icon dense v-if="navigationDrawer.miniVariant">mdi-chevron-right</v-icon>
                            <v-icon dense v-else>mdi-chevron-left</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Ukryj menu</v-list-item-title>
                    </v-list-item>

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
            </v-list>
            <template v-slot:append>
                <v-expansion-panels accordion flat tile>
                    <v-expansion-panel class="ma-0 pa-0">
                        <v-expansion-panel-content
                            id="user-expansion-panel"
                            :color="navigationDrawer.miniVariant ? 'background' : ' navigationDrawerExpanded'"
                        >
                            <v-list
                                nav
                                :color="navigationDrawer.miniVariant ? 'transparent' : 'white'"
                                v-bind:class="{'ma-2 rounded': !navigationDrawer.miniVariant}"
                            >
                                <v-list-item-group active-class="primary--text primary--darken-1">
                                    <v-list-item link dense>
                                        <v-list-item-icon>
                                            <v-icon dense>mdi-account</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title>Profil</v-list-item-title>
                                    </v-list-item>
                                    <v-list-item link dense>
                                        <v-list-item-icon>
                                            <v-badge color="red" dot>
                                                <v-icon dense>mdi-email-outline</v-icon>
                                            </v-badge>
                                        </v-list-item-icon>
                                        <v-list-item-title>Wiadomości</v-list-item-title>
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
                                </v-list-item-group>
                            </v-list>
                        </v-expansion-panel-content>
                        <v-expansion-panel-header
                            :color="navigationDrawer.miniVariant ? 'background' : ' navigationDrawerExpanded'"
                            class="pl-0 py-0" expand-icon="mdi-chevron-up"
                        >
                            <v-list nav dense flat>
                                <v-list-item>
                                    <v-list-item-avatar tile>
                                        <v-badge
                                            color="error"
                                            overlap
                                            right
                                            dot
                                        >
                                            <template v-slot:badge>
                                                <span>1</span>
                                            </template>
                                            <v-avatar size="30">
                                                <v-img src="https://cdn.vuetifyjs.com/images/john.png"></v-img>
                                            </v-avatar>
                                        </v-badge>
                                    </v-list-item-avatar>
                                    <v-list-item-content>
                                        <v-list-item-title>{{user.first_name + " " + user.last_name}}
                                        </v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list>
                        </v-expansion-panel-header>
                    </v-expansion-panel>
                </v-expansion-panels>
            </template>
        </v-navigation-drawer>

        <v-app-bar app flat dense color="background" class="px-5">
            <!--            <v-app-bar-nav-icon v-if="$vuetify.breakpoint.smAndUp" @click.stop="navigationDrawer.drawer = !navigationDrawer.drawer"></v-app-bar-nav-icon>-->
            <v-toolbar-title class="font-weight-bold">Dashboard</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon small>
                <v-icon dense>mdi-bell-outline</v-icon>
            </v-btn>
        </v-app-bar>

        <v-main>
            <v-container fluid>
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
                    drawer: true,
                    miniVariant: true,
                    permanent: true,
                }
            }
        },

        computed: {
            ...mapGetters({
                user: 'auth/user',
            }),
        }
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
