<template>
    <v-app-bar
        app
        flat
        clipped-left
        dark
        color="component-background"
    >
        <v-toolbar-title>
            <b>InternApp</b>
        </v-toolbar-title>

        <v-spacer></v-spacer>

        <v-btn-toggle group>
            <v-btn text plain small :ripple="false" to="/dashboard">
                Dashboard
            </v-btn>
            <v-btn text plain small :ripple="false" to="/universities">
                Uniwersytet
            </v-btn>
            <v-btn text plain small :ripple="false" to="/companies">
                Firma
            </v-btn>
            <v-btn text plain small :ripple="false" to="/internships/1">
                Dziennik Praktyk
            </v-btn>
        </v-btn-toggle>

        <v-divider vertical inset></v-divider>

        <v-menu left bottom offset-y nudge-bottom="3" tile>
            <template v-slot:activator="{ on, attrs }">
                <v-list flat class="py-1" color="transparent">
                    <v-list-item v-bind="attrs" v-on="on" dense link :ripple="false">
                        <v-list-item-avatar color="primary" rounded size="35">
                            <v-img src="https://randomuser.me/api/portraits/men/43.jpg" :alt="user.first_name + ' ' + user.last_name + ' avatar'"></v-img>
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title class="">{{ user.first_name + ' ' + user.last_name }}</v-list-item-title>
                            <v-list-item-subtitle>{{ user.email }}</v-list-item-subtitle>
                        </v-list-item-content>
                        <v-list-item-action>
                            <v-icon>mdi-chevron-down</v-icon>
                        </v-list-item-action>
                    </v-list-item>
                </v-list>
            </template>

            <v-list dense>
                <v-list-item to="/profile">
                    <v-list-item-icon>
                        <v-icon>mdi-account-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Profil</v-list-item-title>
                </v-list-item>
                <v-list-item to="/notifications">
                    <v-list-item-icon>
                        <v-icon>mdi-bell-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Powiadomienia</v-list-item-title>
                </v-list-item>
                <v-list-item to="/messages">
                    <v-list-item-icon>
                        <v-icon>mdi-android-messages</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Wiadomości</v-list-item-title>
                </v-list-item>
                <v-list-item to="/settings">
                    <v-list-item-icon>
                        <v-icon dense>mdi-cog-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Ustawienia</v-list-item-title>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item to="/logout">
                    <v-list-item-icon>
                        <v-icon dense>mdi-power-standby</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Wyloguj</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>

    </v-app-bar>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: "TheAppBarDesktop",

    computed: {
        ...mapGetters({
            user: 'auth/user',
        }),
    }
}
</script>

<style scoped>

</style>
