<template>
    <v-app>
        <v-app-bar
            :flat="true"
            color="transparent"
            dark
            class="px-5"
            :absolute="true"
        >
            <v-toolbar-title class="font-weight-bold">Internships</v-toolbar-title>
        </v-app-bar>
        <v-content class="fill-height">
            <v-container fluid class="pa-0 fill-height">
                <v-row class="fill-height">
                    <v-col
                        cols="5"
                        class="blue accent-4 pt-10 d-flex justify-center align-center fill-height white--text flex-column"
                    >
                        <h3 class="font-weight-medium title font-weight-bold">Posiadasz już konto?</h3>
                        <p class="subtitle-2 mt-2 px-10 text-center">Skorzystaj ze swojego konta by w pełni korzystać z naszego serwisu!</p>
                        <v-btn large outlined color="white" to="login">Zaloguj Się</v-btn>
                    </v-col>
                    <v-col
                        cols="7"
                        class="pt-10 d-flex flex-column justify-center align-center fill-height"
                    >
                        <h2 class="font-weight-medium title font-weight-bold pa-0 ma-2">Jesteś studentem?</h2>
                        <p class="subtitle-2 pa-0 ma-2">Dołącz do naszego serwisu i zarządzaj swoimi praktykami!</p>
                        <student-registration-form></student-registration-form>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    import StudentRegistrationForm from "../components/Students/StudentRegistrationForm";

    export default {
        name: "StudentRegistration",

        components: {
            StudentRegistrationForm
        },

        data() {
            return {

            }
        }
    }
</script>

<style scoped>

</style>
