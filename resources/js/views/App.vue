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
                <v-list-item-group
                    active-class="primary--text primary--darken-1"
                >
                    <v-list-item link to="/" dense>
                        <v-list-item-icon>
                            <v-icon dense>mdi-view-dashboard</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Dashboard</v-list-item-title>
                    </v-list-item>
                </v-list-item-group>

                <v-list-item-group
                    class="mt-1"
                    active-class="primary--text primary--darken-1"
                >
                    <v-subheader v-bind:class="{'hidden': navigationDrawer.miniVariant}" class="caption font-weight-medium text-uppercase">Ogólne</v-subheader>
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

                <v-list-item-group
                    class="mt-1"
                    active-class="primary--text primary--darken-1"
                >
                    <v-subheader v-bind:class="{'hidden': navigationDrawer.miniVariant}" class="caption font-weight-medium text-uppercase">Użytkownik</v-subheader>
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
            <template v-slot:append>
                <v-list nav class="text--secondary">
                    <v-list-item dense @click.stop="navigationDrawer.miniVariant = !navigationDrawer.miniVariant" >
                        <v-list-item-icon>
                            <v-icon dense v-if="navigationDrawer.miniVariant">mdi-chevron-right</v-icon>
                            <v-icon dense v-else>mdi-chevron-left</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title class="caption text-uppercase">Ukryj</v-list-item-title>
                    </v-list-item>
                </v-list>
            </template>
        </v-navigation-drawer>

        <v-app-bar app flat color="background" class="pr-5">
            <v-toolbar-title class="font-weight-bold">Dashboard</v-toolbar-title>
            <v-spacer></v-spacer>
            <template>
                <span class="mr-3 body-2 font-weight-light"><b>{{user.first_name + " " + user.last_name}}</b></span>
                <v-avatar color="primary" size="30"></v-avatar>
            </template>
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

<style lang="scss" scoped>
    #app {
        background-color: #f7f7fa;
        font-family: 'Montserrat', sans-serif;
    }

    .hidden {
        opacity: 0;
    }

</style>
