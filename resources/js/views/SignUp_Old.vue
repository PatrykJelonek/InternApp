<template>
    <v-app>
        <v-content>
            <v-container>
                <v-row>
                    <v-col cols="12">
                        <h1>Rejestracja</h1>
                    </v-col>
                </v-row>
                <v-row class="d-flex justify-center">
                    <v-col cols="8">
                        <v-stepper v-model="step" :alt-labels="altLabels">
                            <v-stepper-header>
                                <v-stepper-step :complete="step > 1" step="1">Dane Logowania</v-stepper-step>
                                <v-divider></v-divider>
                                <v-stepper-step :complete="step > 2" step="2">Dane Personalne</v-stepper-step>
                                <v-divider></v-divider>
                                <v-stepper-step step="3">Typ Konta</v-stepper-step>
                            </v-stepper-header>
                            <v-stepper-items>
                                <v-stepper-content step="1">
                                    <sign-up-login-data></sign-up-login-data>
                                    <v-row>
                                        <v-col cols="12" class="d-flex justify-end">
                                            <v-btn color="primary" @click="step++">Dalej</v-btn>
                                        </v-col>
                                    </v-row>
                                </v-stepper-content>

                                <v-stepper-content step="2">
                                    <sign-up-personal-data></sign-up-personal-data>
                                    <v-row>
                                        <v-col cols="12" class="d-flex">
                                            <v-btn color="secondary" :text="buttonText" @click="step--">Wstecz</v-btn>
                                            <v-spacer></v-spacer>
                                            <v-btn color="primary" @click="step++">Dalej</v-btn>
                                        </v-col>
                                    </v-row>
                                </v-stepper-content>

                                <v-stepper-content step="3">
                                    <router-view></router-view>
                                    <v-row>
                                        <v-col cols="12" class="d-flex">
                                            <v-btn color="secondary" :text="buttonText" @click="step--">Wstecz</v-btn>
                                            <v-spacer></v-spacer>
                                            <v-btn color="primary">Załóż Konto</v-btn>
                                        </v-col>
                                    </v-row>
                                </v-stepper-content>
                            </v-stepper-items>
                        </v-stepper>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    import SignUpLoginData from "../components/SignUpLoginData";
    import SignUpPersonalData from "../components/SignUpPersonalData";

    export default {
        name: "SignUp",
        components: {SignUpPersonalData, SignUpLoginData},
        data() {
            return {
                altLabels: true,
                step: 1,

                buttonText: true,
            }
        },
    }
</script>

<style scoped>

</style>
