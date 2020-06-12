<template>
    <v-container fluid class="pa-0">
        <page-details-header :header="company.name" :subheader="company.description"></page-details-header>
        <v-container class="mt-5">
            <v-row no-gutters class="mb-5">
                <v-col>
                    <v-chip outlined color="grey--text text--darken-2 grey darken-2">
                        <v-icon dense left small>mdi-tag</v-icon>
                        {{ company.category.name }}
                    </v-chip>
                </v-col>
            </v-row>
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
                                <div class="overline mb-4">Lokalizacja</div>
                                <v-list-item-title class="headline mb-2">{{ company.city.name }}</v-list-item-title>
                                <v-list-item-subtitle class="pa-0">
                                    ul. {{ company.street }} {{ company.street_number }}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>

                        <v-card-actions>
                            <v-btn text x-small>Pokaż...</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>

                <v-col cols="auto">
                    <v-card
                        max-width="300"
                        outlined
                        class="fill-height"
                    >
                        <v-list-item three-line>
                            <v-list-item-content>
                                <div class="overline mb-4">Kontakt</div>
                                <v-list-item-title class="headline mb-2">{{ company.email }}</v-list-item-title>
                                <v-list-item-subtitle class="pa-0">
                                    {{ company.website }}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>

                        <v-card-actions>
                            <v-btn text x-small>Wyślij wiadomość...</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>

            <v-row>
                <v-col>
                    <v-tabs v-model="tab" background-color="transparent" color="blue accent-4">
                        <v-tab>Oferty</v-tab>
                    </v-tabs>
                    <v-tabs-items class="transparent mt-5 body-2 text-justify" v-model="tab">
                        <v-tab-item>
                            <v-card outlined>
                                <v-data-table
                                    :headers="headers"
                                    :items="company.offers"
                                    :items-per-page="5"
                                    :loading="isLoading"
                                    @click:row="(item) => {this.$router.push({name: 'offer', params: {id: item.id}})}"
                                ></v-data-table>
                            </v-card>
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
        name: "Company",
        components: {PageDetailsHeader},

        data() {
            return {
                isLoading: true,
                headers: [
                    { text: 'Nazwa', value: 'name' },
                    { text: 'Ilość miejsc', value: 'places_number' },
                    { text: 'Kategoria', value: 'offer_category.name' },
                ],
            }
        },

        computed: {
            ...mapGetters({
                company: 'company/company'
            }),
        },

        methods: {
            ...mapActions({
                fetchCompany: 'company/fetchCompany'
            }),
        },

        created() {
            this.fetchCompany(this.$route.params.id).then(() => {
                this.isLoading = false;
            });
        }
    }
</script>

<style scoped>

</style>
