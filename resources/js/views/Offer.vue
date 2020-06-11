<template>
    <v-container fluid class="pa-10">
        <v-row>
            <v-col cols="12">
                <h2 class="text-uppercase title font-weight-black grey--text text--darken-4">{{ offer.name }}</h2>
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <span class="grey--text text--darken-1">Ilość miejsc: </span> <b>{{ offer.places_number }}</b>
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
