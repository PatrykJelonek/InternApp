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
        <v-content class="fill-height component-background">
            <v-container fluid class="pa-0 fill-height">
                <v-row class="fill-height justify-center align-center">
                    <v-col
                        cols="12" sm="9" md="6" lg="5" xl="3"
                        class="pt-10 d-flex flex-column justify-center align-center fill-height"
                    >
                        <h2 class="font-weight-medium title font-weight-bold pa-0 ma-2">Zarejestruj się za darmo!</h2>
                        <p class="subtitle-2 pa-0 ma-2">Załóż konto by w skorzystać z naszego serwisu.</p>
                        <sing-up-form></sing-up-form>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    import SingUpForm from "../components/SingUpForm";
    export default {
        name: "Registration",
        components: {SingUpForm},
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
