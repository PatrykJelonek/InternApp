<template>
    <v-app>
        <v-app-bar
            :flat="flatNavbar"
            :color="navbarBackground"
            dark
            class="px-5"
            :absolute="isTrue"
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
                        <h3 class="font-weight-medium title font-weight-bold">Nie posiadasz jeszcze konta?</h3>
                        <p class="subtitle-2 mt-2 px-10 text-center">Załóż darmowe konto w naszym serwisie by zarządzać praktykami na uczelni lub pozyskać praktykantów do firmy!</p>
                        <v-btn large outlined color="white" to="register">Zarejestruj się</v-btn>
                    </v-col>
                    <v-col
                        cols="7"
                        class="pt-10 d-flex flex-column justify-center align-center fill-height"
                    >
                        <h2 class="font-weight-medium title font-weight-bold pa-0 ma-2">Logowanie</h2>
                        <p class="subtitle-2 pa-0 ma-2">Zaloguj się na swoje konto by skorzystać ze wszystkich funkcji naszego serwisu!</p>
                        <login-form></login-form>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    import LoginForm from "../components/LoginForm";
    export default {
        name: "Login",
        components: {LoginForm},

        data() {
            return {
                darkTheme: true,
                flatNavbar: true,
                navbarBackground: "transparent",
                inset: false,
                isFalse: false,
                isTrue: true,
                snackbar: false,
                snackbarMessage: '',
            }
        },
    }
</script>

<style scoped>

</style>
