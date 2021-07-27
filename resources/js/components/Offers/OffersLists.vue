<template>
    <v-row>
        <v-col cols="12" v-has="['student','intern']">
            <the-student-offers></the-student-offers>
        </v-col>
        <v-col cols="12">
            <offers-list></offers-list>
        </v-col>
    </v-row>
</template>

<script>
import TheStudentOffers from "./Student/TheStudentOffers";
import OffersList from "./OffersList";
export default {
    name: "OffersLists",
    components: {OffersList, TheStudentOffers}
}
</script>

<style scoped>

</style>
