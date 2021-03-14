<template>
    <v-navigation-drawer
        app
        flat
        right
        floating
        mini-variant
        class="base-background"
    >
        <template v-slot:prepend>
            <v-list-item class="px-2">
                <v-list-item-avatar rounded>
                    <v-img src="https://randomuser.me/api/portraits/women/75.jpg"></v-img>
                </v-list-item-avatar>
            </v-list-item>
        </template>

        <v-list>
            <v-list-item link dense>
                <v-list-item-icon>
                    <v-icon>mdi-view-dashboard</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>Dashboard</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-list-item link dense>
                <v-list-item-icon>
                    <v-icon>mdi-school-outline</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>Uczelnia</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-list-item link dense>
                <v-list-item-icon>
                    <v-icon>mdi-briefcase-outline</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>Firma</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-list-item link dense>
                <v-list-item-icon>
                    <v-icon>mdi-notebook</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>Dziennik Praktyk</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>

        <template v-slot:append>
            <v-list-item link dense>
                <v-list-item-icon>
                    <v-icon dense>mdi-logout-variant</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>Wyloguj</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </template>
    </v-navigation-drawer>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: "TheAppNavigationDrawer",

    computed: {
        ...mapGetters({
            user: 'auth/user',
        }),
    },
}
</script>

<style scoped>

</style>
