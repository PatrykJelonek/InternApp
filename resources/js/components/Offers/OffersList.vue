<template>
    <div>
        <v-data-table
            :headers="headers"
            :items="offers"
            :items-per-page="10"
            :loading="isLoading"
            @click:row="(item) => {loadOffer(item)}"
        ></v-data-table>
        <v-navigation-drawer
            v-model="offerInformation"
            temporary
            clipped
            right
            absolute
            width="50%"
        >
            <v-container class="pa-5">
                <v-row>
                    <v-col>
                        <h2 class="display-1 font-weight-bold">{{ offer.name }}</h2>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="auto" class="grey--text text--darken-1 py-1">
                        Ilość miejsc:
                    </v-col>
                    <v-col class="font-weight-bold py-1">
                        {{ offer.places_number }}
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="auto" class="grey--text text--darken-1 py-1">
                        Kategoria:
                    </v-col>
                    <v-col class="font-weight-bold py-1" v-if="offer.offer_category">
                        {{ offer.offer_category.name }}
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="auto" class="grey--text text--darken-1 py-1">
                        Rozmowa kwalifikacyjna:
                    </v-col>
                    <v-col class="font-weight-bold py-1">
                        {{ offer.interview ? "Tak":"Nie" }}
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="auto" class="grey--text text--darken-1 py-1">
                        Firma:
                    </v-col>
                    <v-col class="font-weight-bold py-1" v-if="offer.company">
                        {{ offer.company.name }}
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="auto" class="grey--text text--darken-1 py-1">
                        Miasto:
                    </v-col>
                    <v-col class="font-weight-bold py-1" v-if="offer.company">
                        {{ offer.company.city.name }}
                    </v-col>
                </v-row>
            </v-container>
        </v-navigation-drawer>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";

    export default {
        name: "OffersList",

        data() {
            return {
                offerInformation: false,
                isLoading: true,
                headers: [
                    { text: 'Nazwa', value: 'name' },
                    { text: 'Ilość miejsc', value: 'places_number' },
                    { text: 'Kategoria', value: 'offer_category.name' },
                    { text: 'Firma', value: 'company.name' },
                    { text: 'Miasto', value: 'company.city.name' },
                ],
                offer: {},
            }
        },

        computed: {
            ...mapGetters({
                offers: 'offer/offers',
            }),
        },

        methods: {
            ...mapActions({
                fetchOffers: 'offer/fetchOffers'
            }),

            loadOffer(item) {
                this.offerInformation = !this.offerInformation;
                this.offer = item;
            },
        },

        created() {
            this.fetchOffers().then(() => {
                this.isLoading = false;
            });
        }
    }
</script>

<style scoped>

</style>
