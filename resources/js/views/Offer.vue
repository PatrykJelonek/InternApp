<template>
    <v-container fluid class="pa-10">
        <v-row>
            <v-col cols="12">
                <h2 class="display-1 text-uppercase font-weight-black grey--text text--darken-4">{{ offer.name }}</h2>
            </v-col>
        </v-row>
        <v-row>
            <v-col class="body-2 text-uppercase blue--text text--accent-4">
                Miejsce
            </v-col>
        </v-row>
        <v-row class="body-2">
            <v-col cols="auto">
                <span class="grey--text text--darken-1">Firma: </span> <b>{{ offer.company.name }}</b>
            </v-col>
            <v-col cols="auto">
                <span class="grey--text text--darken-1">Miasto: </span> <b>{{ offer.company.city.name }}</b>
            </v-col>
        </v-row>
        <v-row>
            <v-col class="body-2 text-uppercase blue--text text--accent-4">
                Informacje
            </v-col>
        </v-row>
        <v-row class="body-2">
            <v-col cols="auto">
                <span class="grey--text text--darken-1">Kategoria: </span> <b>{{ offer.offer_category.name }}</b>
            </v-col>
            <v-col cols="auto">
                <span class="grey--text text--darken-1">Ilość miejsc: </span> <b>{{ offer.places_number }}</b>
            </v-col>
            <v-col cols="auto">
                <span class="grey--text text--darken-1">Wymagana rozmowa kwalifikacyjna: </span> <b>{{ offer.interview ? "Tak":"Nie" }}</b>
            </v-col>
        </v-row>
        <v-row>
            <v-col class="body-2 text-uppercase blue--text text--accent-4">
                Szczegóły
            </v-col>
        </v-row>
        <v-row class="body-2">
            <v-col cols="auto">
                <span class="grey--text text--darken-1">Program: </span> <b>{{ offer.program }}</b>
            </v-col>
        </v-row>
        <v-row class="body-2">
            <v-col cols="auto">
                <span class="grey--text text--darken-1">Harmonogram: </span> <b>{{ offer.schedule }}</b>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";

    export default {
        name: "Offer",

        computed: {
            ...mapGetters({
                offer: 'offer/offer',
            }),
        },

        methods: {
            ...mapActions({
                fetchOffer: 'offer/fetchOffer'
            }),
        },

        created() {
            this.fetchOffer(this.$route.params.id);
        }
    }
</script>

<style scoped>

</style>
