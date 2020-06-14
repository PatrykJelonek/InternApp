<template>
    <v-container fluid class="pa-0 ma-0">
        <page-details-header :header="agreement.offer.name"></page-details-header>
        <v-container class="mt-10">
            <v-row v-if="!agreement.is_active">
                <v-col class="body-2 grey--text text--darken-2">Akcje:</v-col>
            </v-row>
            <v-row v-if="!agreement.is_active">
                <v-col>
                    <v-btn @click="active" color="blue accent-4" dark small>Potwierdź</v-btn>
                </v-col>
            </v-row>

            <v-row class="mt-10">
                <v-col class="body-2 grey--text text--darken-2">Informacje:</v-col>
            </v-row>
            <v-row>
                <v-col cols="auto">
                    <v-card
                        max-width="300"
                        outlined
                        class="fill-height"
                    >
                        <v-list-item three-line>
                            <v-list-item-content>
                                <div class="overline mb-4">Firma</div>
                                <v-list-item-title class="headline mb-2">{{ agreement.company.name }}</v-list-item-title>
                                <v-list-item-subtitle class="pa-0">
                                    ul. {{ agreement.company.street }} {{ agreement.company.street_number }}, {{ agreement.company.city.name }}
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
                        max-width="300"
                        outlined
                        class="fill-height"
                    >
                        <v-list-item three-line>
                            <v-list-item-content>
                                <div class="overline mb-4">Uczelnia</div>
                                <v-list-item-title class="headline mb-2">{{ agreement.university.name }}</v-list-item-title>
                                <v-list-item-subtitle class="pa-0">
                                    ul. {{ agreement.university.street }} {{ agreement.university.street_number }}, {{ agreement.university.city.name }}
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
                        max-width="300"
                        outlined
                        class="fill-height"
                    >
                        <v-list-item two-line>
                            <v-list-item-content>
                                <div class="overline mb-2">Data początkowa porozumienia</div>
                                <v-list-item-title class="headline mb-4">{{ agreement.date_from }}</v-list-item-title>
                                <div class="overline mb-2">Data końcowa porozumienia</div>
                                <v-list-item-title class="headline mb-1">{{ agreement.date_to}}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-card>
                </v-col>
                <v-col cols="auto">
                    <v-card
                        max-width="300"
                        outlined
                        class="fill-height"
                    >
                        <v-list-item two-line>
                            <v-list-item-content>
                                <div class="overline mb-2">Opiekun z firmy</div>
                                <v-list-item-title class="headline mb-4">{{ agreement.offer.supervisor.first_name +' '+ agreement.offer.supervisor.last_name }}</v-list-item-title>
                                <div class="overline mb-2">Opiekun z uczelni</div>
                                <v-list-item-title class="headline mb-1">{{ agreement.university_supervisor.first_name +' '+ agreement.university_supervisor.last_name }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-card>
                </v-col>
            </v-row>

            <v-row class="mt-10">
                <v-col>
                    <v-tabs v-model="tab" background-color="transparent" color="blue accent-4">
                        <v-tab>Program</v-tab>
                        <v-tab>Harmonogram</v-tab>
                        <v-tab>Treść Porozumienia</v-tab>
                    </v-tabs>
                    <v-tabs-items class="transparent mt-5 body-2 text-justify" v-model="tab">
                        <v-tab-item>
                            {{ agreement.program }}
                        </v-tab-item>
                        <v-tab-item>
                            {{ agreement.schedule }}
                        </v-tab-item>
                        <v-tab-item>
                            {{ agreement.content }}
                        </v-tab-item>
                    </v-tabs-items>
                </v-col>
            </v-row>
        </v-container>

        <v-snackbar
            v-model="snackbar"
            bottom
            color="success"
            right
            :timeout="3000"
        >
            Porozumienie zostało potwierdzone!
            <template v-slot:action="{ attrs }">
                <v-btn
                    dark
                    text
                    v-bind="attrs"
                    @click="snackbar = false"
                >
                    Zamknij
                </v-btn>
            </template>
        </v-snackbar>
    </v-container>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';
    import PageDetailsHeader from "../components/Page/PageDetailsHeader";
    export default {
        name: "Agreement",

        components: {PageDetailsHeader},

        data() {
            return {
                tab: null,
                snackbar: false,
            }
        },

        computed: {
            ...mapGetters({
                agreement: 'agreement/agreement'
            }),
        },

        methods: {
            ...mapActions({
                fetchAgreement: 'agreement/fetchAgreement',
                activeAgreement: 'agreement/activeAgreement',
            }),

            toCompany() {
                return this.$router.push({name: 'company', params: {id: this.agreement.company.id}})
            },

            //TODO: Dodać widok uczelni
            toUniversity() {
                return this.$router.push({name: 'company', params: {id: this.agreement.company.id}})
            },

            active() {
                this.activeAgreement(this.agreement.id).then(() => {
                    this.agreement.is_active = true;
                    this.snackbar = true;
                })
            }
        },

        created() {
            this.fetchAgreement(this.$route.params.id);
        },
    }
</script>

<style scoped>

</style>
