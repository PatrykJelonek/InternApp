<template>
    <v-container fluid class="pa-0">
        <page-details-header :header="offer.name" :subheader="offer.offer_category.name"></page-details-header>
        <v-container class="mt-5">
            <v-row>
                <v-col class="body-2 grey--text text--darken-2">Informacje:</v-col>
            </v-row>
            <v-row>
                <v-col cols="auto">
                    <v-card
                        max-width="250"
                        outlined
                        class="fill-height"
                    >
                        <v-list-item three-line>
                            <v-list-item-content>
                                <div class="overline mb-4">Miejsce</div>
                                <v-list-item-title class="headline mb-2">{{ offer.company.name }}</v-list-item-title>
                                <v-list-item-subtitle class="pa-0">
                                    ul. {{ offer.company.street }} {{ offer.company.street_number }}, {{ offer.company.city.name }}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>

                        <v-card-actions>
                            <v-btn @click="toCompany" text x-small>Więcej informacji...</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>

                <v-col cols="auto">
                    <v-card
                        max-width="250"
                        outlined
                        class="fill-height"
                    >
                        <v-list-item three-line>
                            <v-list-item-content>
                                <div class="overline mb-4">Opiekun</div>
                                <v-list-item-title class="headline mb-2">{{ offer.supervisor.first_name }} {{ offer.supervisor.last_name }}</v-list-item-title>
                                <v-list-item-subtitle class="pa-0">
                                    {{ offer.supervisor.email }}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>

                        <v-card-actions>
                            <v-btn @click="toCompany" text x-small>Wyślij wiadomość...</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>

                <v-col cols="auto">
                    <v-card
                        max-width="250"
                        outlined
                        class="fill-height"
                    >
                        <v-list-item two-line>
                            <v-list-item-content>
                                <div class="overline mb-2">Rozmowa kwalifikacyjna</div>
                                <v-list-item-title class="headline mb-4">{{ offer.interview ? "Wymagana":"Niewymagana" }}</v-list-item-title>
                                <div class="overline mb-2">Liczba wolnych miejsc</div>
                                <v-list-item-title class="headline mb-1">{{ offer.places_number }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-card>
                </v-col>
            </v-row>

            <v-row>
                <v-col>
                    <v-tabs v-model="tab" background-color="transparent" color="blue accent-4">
                        <v-tab>Program</v-tab>
                        <v-tab>Harmonogram</v-tab>
                    </v-tabs>
                    <v-tabs-items class="transparent mt-5 body-2 text-justify" v-model="tab">
                        <v-tab-item>
                            {{ offer.program }}
                        </v-tab-item>
                        <v-tab-item>
                            {{ offer.schedule }}
                        </v-tab-item>
                    </v-tabs-items>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";
    import PageDetailsHeader from "../components/Page/PageDetailsHeader";

    export default {
        name: "Offer",
        components: {PageDetailsHeader},
        data() {
            return {
                tab: null,
            }
        },

        computed: {
            ...mapGetters({
                offer: 'offer/offer',
            }),
        },

        methods: {
            ...mapActions({
                fetchOffer: 'offer/fetchOffer'
            }),

            toCompany() {
                return this.$router.push({name: 'company', params: {id: this.offer.company.id}})
            },
        },

        created() {
            this.fetchOffer(this.$route.params.id);
        }
    }
</script>

<style scoped>
    .detail_header {
        height: 200px;
    }
</style>
