<template>
    <v-container :fluid="this.$vuetify.breakpoint.lgAndDown" style="margin-top: 100px">
        <v-row class="my-15">
            <v-col cols="12" class="text-center">
                <h3 class="text-h3 font-weight-bold text-uppercase">Funkcjonalności</h3>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" md="6" order-md="2" order="1" order-lg="1" lg="4" class="px-15">
                <v-card elevation="0" class="text-center">
                    <v-icon large class="ma-5">mdi-briefcase-variant-outline</v-icon>
                    <h4 class="text-h6 font-weight-bold green--text text--accent-4">Oferty Praktyk</h4>
                    <v-card-text>
                        <p>
                            Twoja firma poszukuje praktykantów?
                        </p>
                        <p>
                            W łatwy i szybki sposób dodasz ofertę praktyk do naszego systemu. A gdy znajdzie się
                            kandydat równie szybko podpiszesz porozumienie z uczelnią.
                        </p>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" md="12" order-md="1" order="2" order-lg="2" lg="4" class="px-15">
                <v-card elevation="0" class="text-center">
                    <v-icon large class="ma-5">mdi-book-open-outline</v-icon>
                    <h4 class="text-h6 font-weight-bold green--text text--accent-4">Dziennik Praktyk</h4>
                    <v-card-text>
                        <p>
                            Wiemy jak ważna jest dobra dokumentacja.
                        </p>
                        <p>
                            Dlatego każdy student ma możliwość prowadzenia dziennika praktyk, a poza wpisami studentów,
                            każdy z opiekunów może wyznaczyć studentowi zadania do realizacji. W ten sposób aktywność
                            studenta zostanie udokumentowana, a każda ze stron będzie miała prosty wgląd w działania
                            swoich podopiecznych.
                        </p>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" md="6" order-md="3" order="3" order-lg="3" lg="4" class="px-15">
                <v-card elevation="0" class="text-center">
                    <v-icon large class="ma-5">mdi-application-cog</v-icon>
                    <h4 class="text-h6 font-weight-bold green--text text--accent-4">System Ankiet</h4>
                    <v-card-text>
                        <p>
                            Wiedza i dobre samopoczucie to podstawa.
                        </p>
                        <p>
                            Dlatego dajemy Ci dostęp do systemu ankiet dzięki któremu będziesz mógł zbadać opinie
                            studentów po odbytej praktyce. Możesz również dowiedzieć się co myślą o twojej firmie. To Ty
                            decydujesz jak dana ankieta będzie wyglądać.
                        </p>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        <v-row class="text--secondary text-subtitle-2 mx-15">
            <v-col cols="12" class="text-center">
                To tylko część funkcjonalności które czekają na Ciebie w naszym systemie.
                <router-link class="green--text text--accent-4" :to="{name: 'register'}">Załóż konto</router-link>
                już dziś i zarządzaj praktykami w sieci.
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import LandingPageProfit from "./LandingPageProfit";

export default {
    name: "TheLandingPageProfits",
    components: {LandingPageProfit},
    data() {
        return {
            slider: null,
        }
    }
}
</script>

<style scoped>

</style>
