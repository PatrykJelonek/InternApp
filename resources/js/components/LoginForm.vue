<template>
    <v-container>
        <v-form>
            <v-row class="d-flex justify-center">
                <v-col cols="8">
                    <v-text-field
                        label="Email"
                        type="email"
                        v-model="loginData.email"
                        outlined
                        dense
                        hide-details="auto"
                        placeholder="jankowalski@example.com"
                        :rules="[rules.required]"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row class="d-flex justify-center">
                <v-col cols="8">
                    <v-text-field
                        label="Hasło"
                        v-model="loginData.password"
                        type="password"
                        outlined
                        dense
                        hide-details="auto"
                        placeholder="●●●●●●●"
                        :rules="[rules.required]"
                        :error-messages="errorMessage"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row class="d-flex justify-center">
                <v-col cols="8" class="d-flex justify-end">
                    <v-btn color="blue accent-4" dark large @click="submit">Zaloguj Się</v-btn>
                </v-col>
            </v-row>
        </v-form>
    </v-container>
</template>

<script>
    import {mapActions} from "vuex";

    export default {
        name: "LoginForm",
        data() {
            return {
                loginData: {
                    email: '',
                    password: ''
                },

                errorMessage: '',

                persistentHint: false,

                rules: {
                    required: value => !!value || 'To pole jest wymagane!',
                    minPasswordLength: value => value.length >= 6 || 'Hasło musi zawierać min. 6 znaków!',
                }
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
    }
</script>

<style scoped>

</style>
