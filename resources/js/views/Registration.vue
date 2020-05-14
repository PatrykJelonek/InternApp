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
                        <h3 class="font-weight-medium title font-weight-bold">Posiadasz już konto?</h3>
                        <p class="subtitle-2 mt-2">Skorzystaj ze swojego konta by w pełni korzystać z naszego serwisu!</p>
                        <v-btn large outlined color="white">Zaloguj Się</v-btn>
                    </v-col>
                    <v-col
                        cols="7"
                        class="pt-10 d-flex flex-column justify-center align-center fill-height"
                    >
                        <h2 class="font-weight-medium title font-weight-bold pa-0 ma-2">Zarejestruj się za darmo!</h2>
                        <p class="subtitle-2 pa-0 ma-2">Zarzadzaj praktykami na swojej uczelni lub pozyskaj praktykantów do swojej firmy!</p>
                        <sing-up-form></sing-up-form>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    import SignUpLoginData from "../components/SignUpLoginData";
    import SingUpForm from "../components/SingUpForm";
    export default {
        name: "Registration",
        components: {SingUpForm, SignUpLoginData},
        data() {
            return {
                darkTheme: true,
                flatNavbar: true,
                navbarBackground: "transparent",
                inset: false,
                isFalse: false,
                isTrue: true,
            }
        },
    }
</script>

<style scoped>

</style>
