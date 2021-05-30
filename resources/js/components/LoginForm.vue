<template>
    <v-container>
        <validation-observer ref="observer" v-slot="{ validate }">
            <v-form>
                <v-row>
                    <v-col cols="12">
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
                    <v-col cols="12">
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
                <v-row>
                    <router-link class="text-caption ml-4" :to="{name: 'forgot-password'}">Nie pamiętam hasła!</router-link>
                </v-row>
                <v-row>
                    <v-col cols="6" class="d-flex justify-start">
                        <v-btn color="secondary" text type="submit" dark :to="{name: 'register'}">Rejestracja</v-btn>
                    </v-col>
                    <v-col cols="6" class="d-flex justify-end">
                        <v-btn color="primary" outlined dark @click="submit">Zaloguj Się</v-btn>
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
                }).catch((e) => {
                    if (e.response.status === 401) {
                        this.$refs.observer.setErrors({password: 'Podane dane dostępowe nie są prawidłowe!'})
                    }

                    this.$refs.observer.setErrors(e.response.data.errors);
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
