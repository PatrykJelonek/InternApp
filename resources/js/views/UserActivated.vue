<template>
    <v-app class="component-background">
        <v-app-bar
            flat
            color="transparent"
            dark
            class="px-5"
            absolute
        >
            <v-toolbar-title class="font-weight-bold">Internships</v-toolbar-title>
        </v-app-bar>
        <v-container fluid class="pa-0 d-flex justify-center align-center fill-height component-background">
            <v-row no-gutters class="d-flex justify-center align-center">
                <v-col cols="6" class="text-center">
                    <template v-if="!processed && activated">
                        <v-icon color="success" large>mdi-check-decagram-outline</v-icon>
                        <h2>Twoje konto zostało aktywowane!</h2>
                        <p class="text-body-2">Od teraz możesz w pełni korzystać z serwisu InternApp</p>
                        <v-btn outlined color="primary" class="mt-5" :to="{name: 'login'}">Logowanie</v-btn>
                    </template>
                    <template v-else-if="!processed && !activated">
                        <v-icon color="error" large>mdi-alert-decagram-outline</v-icon>
                        <h2>Wystąpił problem podczas aktywacji konta!</h2>
                        <p class="text-body-2">Skontaktuj się z administratorem serwisu</p>
                        <v-btn outlined color="primary" class="mt-5" :to="{name: 'login'}">Logowanie</v-btn>
                    </template>
                    <template v-else>
                        <v-progress-circular indeterminate color="primary"></v-progress-circular>
                    </template>
                </v-col>
            </v-row>
        </v-container>
    </v-app>
</template>

<script>
import {mapActions} from "vuex";

export default {
    name: "UserActivated",

    data() {
        return {
            activated: false,
            processed: true,
        }
    },

    methods: {
        ...mapActions({
            'activateUser': 'user/activateUser'
        })
    },

    created() {
        if (this.$route.params.activationToken) {
            this.activateUser(this.$route.params.activationToken).then((response) => {
                this.activated = true;
                this.processed = false;
            }).catch((e) => {
                this.processed = false;
            });
        } else {
            // this.$router.push({name: 'not-found'});
        }
    }
}
</script>

<style scoped>

</style>
