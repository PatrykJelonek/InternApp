<template>
    <v-container>
        <page-title>Oferty Praktyk</page-title>
        <v-row>
            <v-col cols="12">
                <offers-list v-has="['admin','university_owner','deanery_worker']"></offers-list>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" v-has="['student']">
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
