<template>
    <v-app-bar
        app
        flat
        clipped-left
        color="grey lighten-5"
    >
        <v-toolbar-title>
            <b>Intern<span class="green--text text--accent-4">App</span></b>
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn
            outlined
            v-if="user"
            small
            dark
            elevation="0"
            color="green accent-4"
            :to="{name: 'panel'}"
        >
            Panel Użytkownika
        </v-btn>
        <v-btn-toggle
            dense
            borderless
            v-if="!user"
            background-color="transparent"
        >
            <v-btn
                text
                color="secondary"
                :to="{name: 'login'}"
            >
                Logowanie
            </v-btn>
            <v-divider vertical></v-divider>
            <v-btn
                text
                color="primary"
                :to="{name: 'register'}"
            >
                Rejestracja
            </v-btn>
        </v-btn-toggle>
    </v-app-bar>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: "TheLandingPageAppBar",

    computed: {
        ...mapGetters({
            user: 'auth/user',
        }),
    },
}
</script>

<style scoped>

</style>
