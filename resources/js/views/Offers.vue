<template>
    <v-container>
        <page-title>Oferty Praktyk</page-title>
        <v-row v-has="['admin','university_owner','deanery_worker']">
            <v-col cols="12">
                <offers-list></offers-list>
            </v-col>
        </v-row>
        <v-row v-has="['student']">
            <v-col cols="12">
                <student-offers-list></student-offers-list>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import OffersList from "../components/Offers/OffersList";
    import PageDetailsHeader from "../components/Page/PageDetailsHeader";
    import PageTitle from "../components/_Helpers/PageTitle";
    import StudentOffersList from "../components/Offers/StudentOffersList";

    export default {
        name: "Offers",

        components: {StudentOffersList, PageTitle, PageDetailsHeader, OffersList},

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
