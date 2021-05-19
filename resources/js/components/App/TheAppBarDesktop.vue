<template>
    <v-app-bar app flat dark clipped-left color="#112A52">
        <!-- Nav Icon -->
        <v-app-bar-nav-icon @click="toggleNavigationDrawer(!navigationDrawer)"></v-app-bar-nav-icon>
        <v-divider vertical></v-divider>
        <user-company-selector v-if="$route.name.match(/company-*[a-z]*/g)"></user-company-selector>
        <user-university-selector v-if="$route.name.match(/university-*[a-z]*/g)"></user-university-selector>
        <v-spacer></v-spacer>
        <v-divider vertical inset></v-divider>
        <v-menu left bottom offset-y nudge-bottom="3" tile>
            <template v-slot:activator="{ on, attrs }">
                <v-list flat class="py-1" color="transparent">
                    <v-list-item v-bind="attrs" v-on="on" dense link :ripple="false">
                        <v-list-item-avatar color="primary" rounded size="35">
                            <v-img src="https://randomuser.me/api/portraits/men/43.jpg"
                                   :alt="user.first_name + ' ' + user.last_name + ' avatar'"></v-img>
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
                <v-list-item :to="{name: 'user', params: {id: user.id}}">
                    <v-list-item-icon>
                        <v-icon>mdi-account-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Profil</v-list-item-title>
                </v-list-item>
                <v-list-item :to="{name: 'notifications'}">
                    <v-list-item-icon>
                        <v-icon>mdi-bell-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Powiadomienia</v-list-item-title>
                </v-list-item>
                <v-list-item :to="{name: 'chats'}">
                    <v-list-item-icon>
                        <v-icon>mdi-android-messages</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Wiadomości</v-list-item-title>
                </v-list-item>
                <v-list-item :to="{name: 'settings'}">
                    <v-list-item-icon>
                        <v-icon dense>mdi-cog-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Ustawienia</v-list-item-title>
                </v-list-item>
                <v-divider v-has="['admin']"></v-divider>
                <v-list-item v-has="['admin']" :to="{name: 'admin'}">
                    <v-list-item-icon>
                        <v-icon>mdi-account-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Panel Administratora</v-list-item-title>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item>
                    <v-list-item-icon>
                        <v-icon dense>mdi-theme-light-dark</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>{{ $vuetify.theme.dark ? 'Tryb ciemny' : 'Tryb jasny' }}</v-list-item-title>
                    <v-list-item-action class="mr-2">
                        <v-switch
                            v-model="$vuetify.theme.dark"
                            inset
                            dense
                            persistent-hint
                            hide-details
                        ></v-switch>
                    </v-list-item-action>
                </v-list-item>
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
import {mapActions, mapGetters} from "vuex";
import UserCompanySelector from "./UserCompanySelector";
import UserUniversitySelector from "./UserUniversitySelector";

export default {
    name: "TheAppBarDesktop",
    components: {UserUniversitySelector, UserCompanySelector},
    computed: {
        ...mapGetters({
            user: 'auth/user',
            navigationDrawer: 'helpers/navigationDrawer'
        }),
    },

    methods: {
        ...mapActions({
            toggleNavigationDrawer: 'helpers/toggleNavigationDrawer'
        }),
    },

    watch: {},
}
</script>

<style scoped>

</style>
