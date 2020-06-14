<template>
    <v-container fluid class="pa-0 ma-0">
        <page-details-header header="Nowa oferta"></page-details-header>
        <v-container class="mt-5">
            <v-row class="d-flex justify-center">
                <v-col cols="10">
                    <offer-create-form></offer-create-form>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
</template>

<script>
    import OfferCreateForm from "../components/Offers/OfferCreateForm";
    import PageDetailsHeader from "../components/Page/PageDetailsHeader";
    export default {
        name: "OfferCreate",
        components: {PageDetailsHeader, OfferCreateForm}
    }
</script>

<style scoped>

</style>
