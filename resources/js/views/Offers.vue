<template>
    <v-container fluid class="pa-10">
        <v-row>
            <v-col>
                <h2 class="text-uppercase title font-weight-black grey--text text--darken-4">Oferty</h2>
            </v-col>
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
</template>

<script>
    import OffersList from "../components/Offers/OffersList";

    export default {
        name: "Offers",

        components: {OffersList},

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
