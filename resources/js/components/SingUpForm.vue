<template>
    <v-container>
        <v-form>
            <v-row class="d-flex justify-center">
                <v-col cols="4">
                    <v-text-field
                        label="Imię"
                        v-model="account.firstName"
                        outlined
                        dense
                        hide-details="auto"
                        placeholder="Jan"
                        :error-messages="this.validationErrors.firstName"
                        :rules="[rules.required]"
                    ></v-text-field>
                </v-col>
                <v-col cols="4">
                    <v-text-field
                        label="Nazwisko"
                        v-model="account.lastName"
                        outlined
                        dense
                        hide-details="auto"
                        placeholder="Kowalski"
                        :error-messages="this.validationErrors.lastName"
                        :rules="[rules.required]"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row class="d-flex justify-center">
                <v-col cols="8">
                    <v-text-field
                        label="Email"
                        type="email"
                        v-model="account.email"
                        outlined
                        dense
                        hide-details="auto"
                        placeholder="jankowalski@example.com"
                        :error-messages="this.validationErrors.email"
                        :rules="[rules.required]"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row class="d-flex justify-center">
                <v-col cols="8">
                    <v-text-field
                        label="Numer Telefonu"
                        type="tel"
                        v-model="account.phone"
                        outlined
                        dense
                        hide-details="auto"
                        placeholder="123-456-789"
                        :error-messages="this.validationErrors.phone"
                        :rules="[rules.required]"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row class="d-flex justify-center">
                <v-col cols="8">
                    <v-text-field
                        label="Hasło"
                        v-model="account.password"
                        type="password"
                        outlined
                        dense
                        hide-details="auto"
                        placeholder="●●●●●●●"
                        :rules="[rules.required, rules.minPasswordLength]"
                        :error-messages="this.validationErrors.password"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row class="d-flex justify-center">
                <v-col cols="8">
                    <v-text-field
                        label="Powtórz Hasło"
                        v-model="account.passwordRepeat"
                        type="password"
                        outlined
                        dense
                        hide-details="auto"
                        placeholder="●●●●●●●"
                        :rules="[rules.required, rules.repeatPassword]"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row class="d-flex justify-center">
                <v-col cols="8">
                    <v-checkbox
                        v-model="account.acceptedRules"
                        color="blue accent-4"
                        class="ma-0"
                        hide-details="auto"
                        :rules="[rules.acceptRules]"
                    >
                        <template v-slot:label>
                            <div>
                                Przeczytałem i akceptuje
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <a target="_blank" href="/rules" @click.stop v-on="on">regulamin</a>
                                    </template>
                                    Otwórz w nowym oknie
                                </v-tooltip>
                                serwisu.
                            </div>
                        </template>
                    </v-checkbox>
                </v-col>
            </v-row>
            <v-row class="d-flex justify-center">
                <v-col cols="8" class="d-flex justify-end">
                    <v-btn color="blue accent-4" dark large @click="submit">Rejestruj</v-btn>
                </v-col>
            </v-row>
        </v-form>
    </v-container>
</template>

<script>
    import {mapActions, mapState} from "vuex";

    export default {
        name: "SingUpForm",
        data() {
            return {
                account: {
                    firstName: "",
                    lastName: "",
                    email: "",
                    phone: "",
                    password: "",
                    passwordRepeat: "",
                    acceptedRules: false
                },
                persistentHint: false,

                rules: {
                    required: value => !!value || 'To pole jest wymagane!',
                    acceptRules: value => !!value || 'Musisz zaakceptować regulamin!',
                    repeatPassword: value => value == this.account.password || 'Hasła muszą być identyczne!',
                    minPasswordLength: value => value.length >= 6 || 'Hasło musi zawierać min. 6 znaków!',
                }
            }
        },
        methods: {
            ...mapActions(["createUserAccount"]),
            submit (e) {
                this.createUserAccount(this.account);
                e.preventDefault();
            }
        },
        computed: {
            ...mapState({
                validationErrors: state => state.user.validationErrors,
            }),
        },
    }
</script>

<style scoped>

</style>
