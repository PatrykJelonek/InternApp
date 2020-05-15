<template>
    <v-app>
        <v-content class="d-flex justify-center align-center">
            <v-container class="d-flex justify-center align-center" fluid>
                <v-form class="col-5">
                    <v-text-field
                        v-model="email"
                        label="Email"
                        type="email"
                        prepend-icon="mdi-at"
                        :full-width="fullWidth"
                        :rules="[rules.requiredEmail]"
                        required
                    ></v-text-field>

                    <v-text-field
                        v-model="password"
                        label="Hasło"
                        type="password"
                        prepend-icon="mdi-lock"
                        :full-width="fullWidth"
                        required
                        :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                        :type="showPassword ? 'text' : 'password'"
                        :rules="[rules.requiredPassword]"
                        @click:append="showPassword = !showPassword"
                    ></v-text-field>
                    <v-row>
                        <v-btn to="sign-up" text type="button" color="secondary">Załóż Konto</v-btn>
                        <v-spacer></v-spacer>
                        <v-btn type="button" color="primary" class="justify-end" @click="submit">Zaloguj Się</v-btn>
                    </v-row>
                </v-form>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    import {mapActions} from "vuex";

    export default {
        name: "SignIn",
        data() {
            return {
                email: '',
                password: '',
                fullWidth: true,
                showPassword: false,
                rules: {
                    requiredEmail: value => !!value || 'Email jest wymagany!',
                    requiredPassword: value => !!value || 'Hasło jest wymagane!',
                }
            }
        },
        methods: {
            ...mapActions(["loginUser"]),
            submit (e) {
                this.loginUser({email: this.email, password: this.password});
                e.preventDefault();
            },
        }
    }
</script>

<style scoped>

</style>
