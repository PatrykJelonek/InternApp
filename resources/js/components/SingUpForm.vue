<template>
    <v-container>
        <v-row class="d-flex justify-center">
            <v-col cols="4">
                <v-text-field
                    label="Imię"
                    v-model="account.firstName"
                    outlined
                    dense
                    hide-details="auto"
                    placeholder="Jan"
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
                ></v-text-field>
            </v-col>
        </v-row>
        <v-row class="d-flex justify-center">
            <v-col cols="8">
                <v-checkbox v-model="account.acceptedRules" color="blue accent-4" class="ma-0" hide-details="auto">
                    <template v-slot:label>
                        <div>
                            Przeczytałem i akceptuje
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <a target="_blank" href="http://vuetifyjs.com" @click.stop v-on="on">regulamin</a>
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
    </v-container>
</template>

<script>
    import {mapActions} from "vuex";

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
            }
        },
        methods: {
            ...mapActions(["createUserAccount"]),
            submit (e) {
                this.createUserAccount(this.account);
                e.preventDefault();
                this.account = {};
            }
        }
    }
</script>

<style scoped>

</style>
