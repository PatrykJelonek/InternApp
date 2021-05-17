<template>
    <v-navigation-drawer app dark color="#28253F">
        <v-list-item>
            <v-list-item-content>
                <v-list-item-title class="title">
                    <b>Intern<span class="green--text text--accent-4">App</span></b>
                </v-list-item-title>
                <v-list-item-subtitle>
                    Solution
                </v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>

        <v-divider></v-divider>

        <v-list nav dense>
            <template v-for="first in items">
                <v-list-item v-if="!first.children" :to="first.to" exact active-class="primary--text">
                    <v-list-item-title>{{ first.text }}</v-list-item-title>
                </v-list-item>
                <v-list-group v-else>
                    <template v-slot:activator>
                        <v-list-item-content :to="first.to" exact>
                            <v-list-item-title> {{ first.text }}</v-list-item-title>
                        </v-list-item-content>
                    </template>
                    <template v-for="second in first.children">
                        <v-list-item link v-if="!second.children" :to="second.to" exact>
                            <v-list-item-icon class="mr-2">
                                <v-icon dense>{{ second.icon }}</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>{{ second.text }}</v-list-item-title>
                        </v-list-item>
                        <v-list-group sub-group no-action v-else>
                            <template v-slot:activator>
                                <v-list-item-content :to="second.to" exact>
                                    <v-list-item-title>{{ second.text }}</v-list-item-title>
                                </v-list-item-content>
                            </template>
                            <template v-slot:prependIcon class="mr-2">
                                <v-icon dense class="mr-0">{{ second.icon }}</v-icon>
                            </template>
                            <template v-slot:appendIcon>
                                <v-icon>mdi-chevron-down</v-icon>
                            </template>
                            <v-list-item link :to="third.to" v-if="second.children" v-for="third in second.children" :key="third.text" exact>
                                <v-list-item-title>{{ third.text }}</v-list-item-title>
                            </v-list-item>
                        </v-list-group>
                    </template>
                </v-list-group>
            </template>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: "TheAppNavigationDrawer",
    props: ['items'],

    computed: {
        ...mapGetters({
            user: 'auth/user',
        }),
    },
}
</script>

<style scoped>

</style>
