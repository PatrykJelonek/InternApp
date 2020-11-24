<template>
    <v-app>
        <dashboard-navigation></dashboard-navigation>
        <v-app-bar
            app
            flat
            dark
            clipped-left
            clipped-right
            color="blue accent-4">
            <v-toolbar-title class="font-weight-bold">Internships</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-menu bottom left offset-y>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn
                        dark
                        text
                        v-bind="attrs"
                        v-on="on"
                        depressed
                    >
                        <span class="ml-2"><b>{{user.first_name + " " + user.last_name}}</b></span>
                        <v-icon class="ml-2">mdi-chevron-down</v-icon>
                    </v-btn>
                </template>

                <v-list dense>
                    <v-list-item to="/account">
                        <v-list-item-title>Profil</v-list-item-title>
                        <v-list-item-icon>
                            <v-icon dense>mdi-account</v-icon>
                        </v-list-item-icon>
                    </v-list-item>
                    <v-list-item to="/messages" v-if="false">
                        <v-list-item-title>Wiadomości</v-list-item-title>
                        <v-list-item-icon>
                            <v-icon dense>mdi-forum</v-icon>
                        </v-list-item-icon>
                    </v-list-item>
                    <v-list-item to="/account-settings" v-if="false">
                        <v-list-item-title>Ustawienia</v-list-item-title>
                        <v-list-item-icon>
                            <v-icon dense>mdi-cog-outline</v-icon>
                        </v-list-item-icon>
                    </v-list-item>
                    <v-divider></v-divider>
                    <v-list-item to="/logout" dense>
                        <v-list-item-title>Wyloguj</v-list-item-title>
                        <v-list-item-icon>
                            <v-icon dense>mdi-exit-to-app</v-icon>
                        </v-list-item-icon>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-app-bar>
        <v-content class="grey lighten-4" app>
            <router-view></router-view>
        </v-content>
    </v-app>
</template>

<script>
    import DashboardNavigation from "../components/DashboardNavigation";
    import {mapGetters} from "vuex";

    export default {
        components: {DashboardNavigation},

        data() {
            return {
                drawer: true,
                permament: true,
                miniVariant: true,
                expandOnHover: true,
                background: false,
            }
        },

        computed: {
            ...mapGetters({
                user: 'auth/user',
            }),
        }
    }
</script>

<style scoped>

</style>
