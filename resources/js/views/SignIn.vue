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
                        label="Hasło"
                        type="password"
                        prepend-icon="mdi-lock"
                        :full-width="fullWidth"
                        required
                        :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                        :type="showPassword ? 'text' : 'password'"
                        :rules="[rules.requiredPassword, rules.min]"
                        @click:append="showPassword = !showPassword"
                    ></v-text-field>
                    <v-row>
                        <v-btn to="sign-up" text="true" type="button" color="secondary">Załóż Konto</v-btn>
                        <v-spacer></v-spacer>
                        <v-btn type="button" color="primary" class="justify-end">Zaloguj Się</v-btn>
                    </v-row>
                </v-form>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    export default {
        data() {
            return {
                email: '',
                password: '',
                fullWidth: true,
                showPassword: false,
                rules: {
                    requiredEmail: value => !!value || 'Email jest wymagany!',
                    requiredPassword: value => !!value || 'Hasło jest wymagane!',
                    min: value => value.length >= 8 || 'Hasło musi zawierać min. 8 znaków!',
                }
            }
        },
        name: "SignIn"
    }
</script>

<style scoped>

</style>
