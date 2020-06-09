<template>
    <v-container fluid class="pa-10">
        <v-row>
            <v-col cols="12">
                <h2 class="text-uppercase title font-weight-black grey--text text--darken-4">Utwórz ofertę</h2>
            </v-col>
        </v-row>
        <v-row class="d-flex justify-center">
            <v-col cols="8">
                <offer-create-form></offer-create-form>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import OfferCreateForm from "../components/Offers/OfferCreateForm";
    export default {
        name: "OfferCreate",
        components: {OfferCreateForm}
    }
</script>

<style scoped>

</style>
