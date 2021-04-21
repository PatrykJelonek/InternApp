<template>
    <v-app>
        <the-landing-page-app-bar></the-landing-page-app-bar>
        <v-main>
            <v-container class="mt-15">
                <v-row>
                    <v-col cols="12" class="text-center">
                        <h1>System planowania i rozliczania studenckich praktyk zawodowych.</h1>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
        <the-landing-page-footer></the-landing-page-footer>
    </v-app>
</template>

<script>
import TheLandingPageAppBar from "../components/LandingPage/TheLandingPageAppBar";
import TheLandingPageFooter from "../components/LandingPage/TheLandingPageFooter";

export default {
    name: "LandingPage",
    components: {TheLandingPageFooter, TheLandingPageAppBar},
}
</script>

<style scoped>

</style>
