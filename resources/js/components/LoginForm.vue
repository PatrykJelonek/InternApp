<template>
    <v-container>
        <validation-observer ref="observer" v-slot="{ validate }">
            <v-form>
                <v-row class="d-flex justify-center">
                    <v-col cols="8">
                        <validation-provider v-slot="{ errors }"  vid="email" rules="requiredEmail|email">
                            <v-text-field
                                label="Email"
                                type="email"
                                v-model="loginData.email"
                                outlined
                                dense
                                hide-details="auto"
                                placeholder="jankowalski@example.com"
                                :error-messages="errors"
                            ></v-text-field>
                        </validation-provider>
                    </v-col>
                </v-row>
                <v-row class="d-flex justify-center">
                    <v-col cols="8">
                        <validation-provider v-slot="{ errors }"  vid="password" rules="requiredPassword">
                            <v-text-field
                                label="Hasło"
                                v-model="loginData.password"
                                type="password"
                                outlined
                                dense
                                hide-details="auto"
                                placeholder="●●●●●●●"
                                :error-messages="errors"
                            ></v-text-field>
                        </validation-provider>
                    </v-col>
                </v-row>
                <v-row class="d-flex justify-center">
                    <v-col cols="8" class="d-flex justify-end">
                        <v-btn color="blue accent-4" type="submit" dark large @click="submit">Zaloguj Się</v-btn>
                    </v-col>
                </v-row>
            </v-form>
        </validation-observer>
    </v-container>
</template>

<script>
    import {mapActions} from "vuex";
    import { required, email } from "vee-validate/dist/rules";
    import {  extend, setInteractionMode, ValidationProvider, ValidationObserver } from "vee-validate";

    setInteractionMode('eager');

    export default {
        name: "LoginForm",

        components: {
            ValidationProvider,
            ValidationObserver
        },

        data() {
            return {
                loginData: {
                    email: '',
                    password: ''
                },
                errorMessage: '',
                persistentHint: false,
            }
        },

        methods: {
            ...mapActions({
                signIn: 'auth/signIn',
            }),
            async submit () {
                await this.signIn({email: this.loginData.email, password: this.loginData.password}).then(() => {
                    this.$router.go('/dashboard');
                }).catch(() => {
                    this.errorMessage = "Email lub hasło jest niepoprawne!";
                });
            },
        }
    };

    extend('requiredEmail', {
        ...required,
        message: 'Email jest wymagany!',
    });

    extend('requiredPassword', {
        ...required,
        message: 'Hasło jest wymagane!',
    });

    extend('email', {
        ...email,
        message: 'Podaj prawidłowy adres email!',
    });
</script>

<style scoped>

</style>
