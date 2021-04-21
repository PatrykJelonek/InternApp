<template>
    <v-container fluid class="pa-0 ma-0">
        <page-details-header header="Ofety" subheader="Tu znajdziesz wzystkie oferty w serwisie!"></page-details-header>
        <v-container class="mt-10">
            <v-row>
                <v-col class="d-flex justify-end align-center">
                    <v-btn text to="create-offer">
                        Dodaj Ofertę
                    </v-btn>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <offers-list></offers-list>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
</template>

<script>
    import OffersList from "../components/Offers/OffersList";
    import PageDetailsHeader from "../components/Page/PageDetailsHeader";

    export default {
        name: "Offers",

        components: {PageDetailsHeader, OffersList},

        data() {
            return {
                breadcrumbs: [
                    {
                        text: 'Dashboard',
                        to: 'dashboard'
                    },
                    {
                        text: 'Oferty',
                        to: 'offers',
                        disabled: true
                    },
                ]
            }
        }
    }
</script>

<style scoped>

</style>
