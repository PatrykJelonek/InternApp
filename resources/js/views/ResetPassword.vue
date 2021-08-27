<template>
    <v-app>
        <app-bar-minimal></app-bar-minimal>
        <v-main>
            <v-content class="fill-height component-background">
                <v-container fluid class="pa-0 fill-height">
                    <v-row class="fill-height justify-center align-center">
                        <v-col
                            cols="12" sm="9" md="6" lg="5" xl="3"
                            class="pt-10 d-flex flex-column justify-center align-center fill-height"
                        >
                            <h2 class="font-weight-medium title font-weight-bold pa-0 ma-2">Zmień hasło</h2>
                            <p class="subtitle-2 pa-0 ma-2 text-center">Zaloguj się na swoje konto by skorzystać ze
                                wszystkich funkcji naszego serwisu!</p>
                            <v-container>
                                <validation-observer ref="observer" v-slot="{ validate }">
                                    <v-form>
                                        <validation-provider
                                            v-slot="{ errors }"
                                            vid="password"
                                            rules="required"
                                        >
                                            <v-text-field
                                                label="Nowe hasło"
                                                v-model="password"
                                                outlined
                                                dense
                                                hide-details="auto"
                                                full-width
                                                type="password"
                                                placeholder="jankowalski@example.com"
                                                :error-messages="errors"
                                                class="mb-5"
                                            ></v-text-field>
                                        </validation-provider>
                                        <validation-provider
                                            v-slot="{ errors }"
                                            vid="passwordRepeat"
                                            rules="required"
                                        >
                                            <v-text-field
                                                label="Powtórz nowe hasło"
                                                v-model="passwordRepeat"
                                                outlined
                                                dense
                                                hide-details="auto"
                                                full-width
                                                type="password"
                                                :error-messages="errors"
                                            ></v-text-field>
                                        </validation-provider>
                                    </v-form>
                                </validation-observer>
                            </v-container>
                            <v-container>
                                <v-row>
                                    <v-col cols="12" class="d-flex justify-center">
                                        <v-btn color="primary" outlined dark @click="submit">Zmień hasło</v-btn>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-col>
                    </v-row>
                </v-container>
            </v-content>
        </v-main>
    </v-app>
</template>

<script>
import {extend, setInteractionMode, ValidationProvider, ValidationObserver} from "vee-validate";
import {mapActions} from "vuex";
import AppBarMinimal from "../components/App/AppBarMinimal";

setInteractionMode('eager');

export default {
    name: "ResetPassword",

    components: {
        AppBarMinimal,
        ValidationProvider,
        ValidationObserver
    },

    data() {
        return {
            token: null,
            password: null,
            passwordRepeat: null,
        }
    },

    methods: {
        ...mapActions({
            resetPassword: 'auth/resetPassword',
            setSnackbar: 'snackbar/setSnackbar',
        }),

        async submit() {
            await this.resetPassword({
                token: this.token,
                password: this.password,
                passwordRepeat: this.passwordRepeat
            }).then(() => {
                this.setSnackbar({message: "Hasło zostało zmienione! Za chwile zostaniesz przekierowany do formularza logowania!", color: 'success'});
                window.setTimeout(() => {
                    this.$router.push({name: 'login'});
                }, 3000);
            }).catch((e) => {
                this.setSnackbar({message: "Wystąpił błąd, skontaktuj się z administratorem serwisu!", color: 'error'});
            });
        }
    },

    created() {
        this.token = this.$route.params.token;
    }
}
</script>

<style scoped>

</style>
