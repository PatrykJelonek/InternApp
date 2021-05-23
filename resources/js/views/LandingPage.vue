<template>
    <v-app class="grey lighten-5">
        <the-landing-page-app-bar></the-landing-page-app-bar>
        <v-main>
            <the-landing-page-hero></the-landing-page-hero>
            <the-landing-page-profits></the-landing-page-profits>
            <v-row class="grey lighten-3" style="margin-top: 100px">
                <v-col>
                    <the-landing-page-offers></the-landing-page-offers>
                </v-col>
            </v-row>
        </v-main>
        <the-landing-page-footer></the-landing-page-footer>
    </v-app>
</template>

<script>
import TheLandingPageAppBar from "../components/LandingPage/TheLandingPageAppBar";
import TheLandingPageFooter from "../components/LandingPage/TheLandingPageFooter";
import TheLandingPageHero from "../components/LandingPage/TheLandingPageHero";
import TheLandingPageProfits from "../components/LandingPage/TheLandingPageProfits";
import TheLandingPageOffers from "../components/LandingPage/TheLandingPageOffers";

export default {
    name: "LandingPage",
    components: {
        TheLandingPageOffers,
        TheLandingPageProfits,
        TheLandingPageHero,
        TheLandingPageFooter,
        TheLandingPageAppBar
    },

    data() {
        return {
        }
    },

    computed: {
        theme() {
            return 'light';
        }
    },

    created() {
        this.$vuetify.theme.dark = false;
    }
}
</script>

<style scoped>

</style>
