<template>
    <v-app>
        <v-app-bar
            :flat="true"
            color="transparent"
            dark
            class="px-5"
            :absolute="true"
        >
            <v-toolbar-title class="font-weight-bold">InternApp</v-toolbar-title>
        </v-app-bar>
        <v-main>
            <v-content class="fill-height">
                <v-container fluid class="pa-0 fill-height">
                    <v-row class="fill-height justify-center align-center">
                        <v-col
                            cols="12" sm="9" md="6" lg="5" xl="3"
                            class="pt-10 d-flex flex-column justify-center align-center fill-height"
                        >
                            <h2 class="font-weight-medium title font-weight-bold pa-0 ma-2">Przypomij hasło</h2>
                            <p class="subtitle-2 pa-0 ma-2 text-center">Zaloguj się na swoje konto by skorzystać ze
                                wszystkich funkcji naszego serwisu!</p>
                            <v-container>
                                <forgot-password-form></forgot-password-form>
                            </v-container>
                            <v-container>

                            </v-container>
                        </v-col>
                    </v-row>
                </v-container>
            </v-content>
            <snackbar></snackbar>
        </v-main>
    </v-app>
</template>

<script>
import {extend, setInteractionMode, ValidationProvider, ValidationObserver} from "vee-validate";
import {mapActions} from "vuex";
import Snackbar from "../components/_Helpers/Snackbar";
import ForgotPasswordForm from "../components/_Other/ForgotPasswordForm";

setInteractionMode('eager');

export default {
    name: "ForgotPassword",

    components: {
        ForgotPasswordForm,
        Snackbar,
        ValidationProvider,
        ValidationObserver
    },

    data() {
        return {
            email: null,
        }
    },

    methods: {
        ...mapActions({
            forgotPassword: 'auth/forgotPassword',
            setSnackbar: 'snackbar/setSnackbar'
        }),

        async submit() {
            this.$refs.observer.validate();
            await this.forgotPassword(this.email).then(() => {
                this.setSnackbar({message: 'Link do zresetowania hasła został wysłany!', color: 'success'});
            }).catch((e) => {
                this.setSnackbar({message: 'Nie udało się wysłać linku, skontaktuj się z administracją serwisu!', color: 'error'});
            });
        }
    }
}
</script>

<style scoped>

</style>
