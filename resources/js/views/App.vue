<template>
    <v-app>
        <v-navigation-drawer
            app
            dark
            mini-variant
            color="primary">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="title font-weight-black pl-2 text-uppercase">
                        Internships
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>

            <v-list dense nav>
                <v-list-item
                    link
                    v-for="link in menu.links"
                    :key="link.name"
                    v-can="link.can"
                    v-has="link.has"
                    :to="link.href"
                >
                    <v-list-item-icon>
                        <v-icon>{{ link.icon }}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>{{ link.name }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <!--        <v-app-bar-->
        <!--            app-->
        <!--            flat-->
        <!--            color="primary"-->
        <!--            dense-->
        <!--        >-->
        <!--            <template>-->
        <!--                <router-view name="tabs"></router-view>-->
        <!--            </template>-->
        <!--        </v-app-bar>-->

        <v-main>

            <v-container class="abc" fluid>
                <sidebar></sidebar>

                <!-- If using vue-router -->
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
    $main-color: #181F47;

    .border {
        box-sizing: content-box;
        border-bottom: 1px solid rgba(0, 0, 0, .1);
    }

    .abc {
        display: flex;
        height: 100%;
        padding: 0;
        background: rgba(0, 0, 0, 0.05);
    }
</style>
