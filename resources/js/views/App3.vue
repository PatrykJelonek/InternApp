<template>
    <v-app>
        <v-app-bar app flat color="light" height="60px" class="pa-0 ma-0">
            <v-toolbar-title class="font-weight-bold logo pa-0 ma-0">Intern</v-toolbar-title>
            <v-tabs hide-slider :optional="true" active-class="font-weight-bold" class="subtitle-2">
                <v-tab to="welcome"><v-icon class="mr-3" dense>mdi-view-dashboard</v-icon>Dashboard</v-tab>
                <v-tab to="universities"><v-icon class="mr-3" dense>mdi-school-outline</v-icon>Uniwersytet</v-tab>
                <v-tab to="companies"><v-icon class="mr-3" dense>mdi-briefcase-outline</v-icon>Firma</v-tab>
            </v-tabs>
            <v-spacer></v-spacer>
            <template v-slot:extension >
                <v-tabs dark show-arrows hide-slider height="50px" color="primary-light" background-color="primary" class="subtitle-2">
                    <v-tab to="/"><v-icon dense class="mr-3">mdi-file-document</v-icon>Ogólne</v-tab>
                    <v-tab to="/universities/agreements"><v-icon dense class="mr-3">mdi-file-document</v-icon>Umowy</v-tab>
                    <v-tab><v-icon dense class="mr-3">mdi-account</v-icon>Studenci</v-tab>
                    <v-tab><v-icon dense class="mr-3">mdi-account-tie</v-icon>Pracownicy</v-tab>
                    <v-tab><v-icon dense class="mr-3">mdi-cog-outline</v-icon>Ustawienia</v-tab>
                </v-tabs>
            </template>
        </v-app-bar>
        <v-main class="secondary">
            <router-view></router-view>
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
                menu: {
                    links: [
                        {name: 'Dashboard', href: {name: 'dashboard'}, icon: 'mdi-view-dashboard', can: [], has: []},
                        {
                            name: 'Uniwersytet',
                            href: {name: 'universities'},
                            icon: 'mdi-school-outline',
                            can: [],
                            has: []
                        },
                        {name: 'Firma', href: {name: 'companies'}, icon: 'mdi-briefcase-outline', can: [], has: []},
                        {
                            name: 'Oferty',
                            href: {name: 'offers'},
                            icon: 'mdi-newspaper-variant-multiple',
                            can: [],
                            has: []
                        },
                        {
                            name: 'Praktyki i staże',
                            href: {name: 'internships'},
                            icon: 'mdi-newspaper',
                            can: [],
                            has: []
                        },
                        {
                            name: 'Dziennik praktyk',
                            href: {name: 'journal'},
                            icon: 'mdi-notebook-outline',
                            can: [],
                            has: []
                        },
                    ]
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
    .logo {
        max-width: 60px;
        min-width: 60px;
        height: 60px;
        background: #223345;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #fff;
        font-size: 14px;
        position: relative;
        left: -16px;
    }
</style>
