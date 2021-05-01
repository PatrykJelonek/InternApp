<template>
    <v-container>
        <v-row v-if="!offerLoading">
            <create-agreement-dialog :offer="offer"></create-agreement-dialog>
            <v-col cols="12">
                <page-title>{{ offer.name }}</page-title>
            </v-col>
            <v-col cols="12" v-has="['university_worker','university_owner','deanery_worker']" class="text-right">
                <v-btn
                    outlined
                    small
                    color="primary"
                    @click="toggleCreateAgreementDialog(true)"
                >
                    Dodaj umowę
                </v-btn>
            </v-col>
            <v-col cols="12" md="6" lg="6">
                <expand-card
                    title="Miejsce praktyk"
                    description="Informacje na temat miejsca odbywania praktyk"
                    :expand="false"
                >
                    <v-list>
                        <v-row>
                            <v-col cols="6">
                                <v-list-item two-line>
                                    <v-list-item-content>
                                        <v-list-item-title>Firma</v-list-item-title>
                                        <v-list-item-subtitle>{{ offer.company.name }}</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item two-line>
                                    <v-list-item-content>
                                        <v-list-item-title>Adres</v-list-item-title>
                                        <v-list-item-subtitle>
                                            {{ offer.company.street + ' ' + offer.company.street_number + ', ' + offer.company.city.name + ' ' + offer.company.city.post_code }}
                                        </v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-col>
                            <v-col cols="6">
                                <v-list-item two-line>
                                    <v-list-item-content>
                                        <v-list-item-title>Email</v-list-item-title>
                                        <v-list-item-subtitle>{{ offer.company.email }}</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item two-line>
                                    <v-list-item-content>
                                        <v-list-item-title>Website</v-list-item-title>
                                        <v-list-item-subtitle>{{ offer.company.website }}</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-col>
                        </v-row>
                    </v-list>
                </expand-card>
            </v-col>
            <v-col cols="12" md="6" lg="6">
                <expand-card
                    title="Informacje"
                    description="Podstawowe informacje na temat praktyki"
                    :expand="false"
                >
                    <v-list>
                        <v-row>
                            <v-col cols="6">
                                <v-list-item two-line>
                                    <v-list-item-content>
                                        <v-list-item-title>Liczba miejsc</v-list-item-title>
                                        <v-list-item-subtitle>{{ offer.places_number }}</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item two-line>
                                    <v-list-item-content>
                                        <v-list-item-title>Data</v-list-item-title>
                                        <v-list-item-subtitle>
                                            {{ formatDate(offer.date_from) + ' - ' + formatDate(offer.date_to) }}
                                        </v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-col>
                            <v-col cols="6">
                                <v-list-item two-line>
                                    <v-list-item-content>
                                        <v-list-item-title>Interview</v-list-item-title>
                                        <v-list-item-subtitle>
                                            <v-chip small :color="offer.interview ? '#C8E6C9' : 'grey lighten-3'">
                                                {{ offer.interview ? 'Wymagane' : 'Niewymagane' }}
                                            </v-chip>
                                        </v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item two-line>
                                    <v-list-item-content>
                                        <v-list-item-title>Kategoria</v-list-item-title>
                                        <v-list-item-subtitle>{{ offer.category.display_name }}</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-col>
                        </v-row>
                    </v-list>
                </expand-card>
            </v-col>
            <v-col cols="12" :xl="offer.schedule !== null ? '6' : '12'">
                <expand-card title="Program praktyk" :expand="false">
                    <v-row>
                        <v-col cols="12" class="pa-7">{{ offer.program }}</v-col>
                    </v-row>
                </expand-card>
            </v-col>
            <v-col cols="12" xl="6" v-if="offer.schedule !== null">
                <expand-card title="Harmonogram praktyk" :expand="false">
                    <v-row>
                        <v-col cols="12" class="pa-7">{{ offer.schedule }}</v-col>
                    </v-row>
                </expand-card>
            </v-col>
        </v-row>
        <v-row v-else class="text-center">
            <v-col cols="12">
                <page-loader></page-loader>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import PageDetailsHeader from "../components/Page/PageDetailsHeader";
import PageTitle from "../components/_Helpers/PageTitle";
import PageLoader from "../components/_General/PageLoader";
import ExpandCard from "../components/_Helpers/ExpandCard";
import moment from "moment";
import CreateAgreementDialog from "../components/Agreements/CreateAgreementDialog";

export default {
    name: "Offer",
    components: {CreateAgreementDialog, ExpandCard, PageLoader, PageTitle, PageDetailsHeader},
    data() {
        return {
            tab: null,
        }
    },

    computed: {
        ...mapGetters({
            offer: 'offer/offer',
            offerLoading: 'offer/offerLoading',
        }),
    },

    methods: {
        ...mapActions({
            fetchOffer: 'offer/fetchOffer',
            toggleCreateAgreementDialog: 'helpers/toggleCreateAgreementDialog',
        }),

        toCompany() {
            return this.$router.push({name: 'company', params: {id: this.offer.company.id}})
        },

        formatDate(date) {
            if (date) {
                return moment(date).format('DD.MM.YYYY');
            }

            return '---';
        },
    },

    created() {
        this.fetchOffer(this.$route.params.slug).then(() => {

        }).catch((e) => {

        });
    }
}
</script>

<style scoped>
.detail_header {
    height: 200px;
}
</style>
