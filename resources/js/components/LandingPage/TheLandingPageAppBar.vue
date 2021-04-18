<template>
    <v-app-bar
        app
        flat
        clipped-left
        color="component-background"
    >
        <v-toolbar-title>
            <b>InternApp</b>
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn
            outlined
            v-if="user"
            color="primary"
            :to="{name: 'dashboard'}"
        >
            Panel
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
            <v-divider  vertical></v-divider>
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
