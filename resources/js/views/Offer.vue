<template>
    <v-container fluid class="pa-0">
        <template v-if="!offerLoading">
            <create-agreement-dialog :offer="offer"></create-agreement-dialog>
            <page-title>
                <template v-slot:default>
                    {{ offer.name }}
                </template>
                <template v-slot:actions>
                    <v-btn
                        outlined
                        color="primary"
                        @click="toggleCreateAgreementDialog(true)"
                    >
                        Dodaj umowę
                    </v-btn>
                    <v-btn
                        outlined
                        color="primary"
                        v-has="['student']"
                        @click="toggleCreateAgreementDialog(true)"
                    >
                        Aplikuj
                    </v-btn>
                </template>
            </page-title>

            <v-row>
                <v-col cols="12" md="6" lg="6">
                    <custom-card>
                        <custom-card-title>
                            <template v-slot:default>Miejsce praktyk</template>
                            <template v-slot:subheader>Informacje na temat miejsca odbywania praktyk</template>
                        </custom-card-title>

                        <v-list class="component-background">
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
                                                {{
                                                    offer.company.street + ' ' + offer.company.street_number + ', ' + offer.company.city.name + ' ' + offer.company.city.post_code
                                                }}
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
                    </custom-card>
                </v-col>
                <v-col cols="12" md="6" lg="6">
                    <custom-card>
                        <custom-card-title>
                            <template v-slot:default>Informacje</template>
                            <template v-slot:subheader>Podstawowe informacje na temat praktyki</template>
                        </custom-card-title>

                        <v-list class="component-background">
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
                                                <v-chip small outlined label :color="offer.interview ? 'warning' : ''">
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
                    </custom-card>
                </v-col>
                <v-col cols="12" :xl="offer.schedule !== null ? '6' : '12'">
                    <custom-card>
                        <custom-card-title>
                            <template v-slot:default>Program praktyk</template>
                            <template v-slot:subheader> </template>
                        </custom-card-title>

                        <v-row no-gutters>
                            <v-col cols="12" class="px-3 py-5">{{ offer.program }}</v-col>
                        </v-row>
                    </custom-card>
                </v-col>
                <v-col cols="12" xl="6" v-if="offer.schedule !== null">
                    <custom-card>
                        <custom-card-title>
                            <template v-slot:default>Harmonogram praktyk</template>
                            <template v-slot:subheader></template>
                        </custom-card-title>

                        <v-row no-gutters>
                            <v-col cols="12" class="px-3 py-5">{{ offer.schedule }}</v-col>
                        </v-row>
                    </custom-card>
                </v-col>
                <v-col cols="12">
                    <custom-card>
                        <custom-card-title>
                            <template v-slot:default>Załączniki</template>
                            <template v-slot:subheader>Lista załączników oferty</template>
                        </custom-card-title>

                        <v-row no-gutters>
                            <v-col cols="12" class="pa-5">
                                <attachments :attachments="offer.attachments"></attachments>
                            </v-col>
                        </v-row>
                    </custom-card>
                </v-col>
            </v-row>

        </template>
        <template v-else>
            <v-row class="text-center">
                <v-col cols="12">
                    <page-loader></page-loader>
                </v-col>
            </v-row>
        </template>
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
import CustomCard from "../components/_General/CustomCard";
import CustomCardTitle from "../components/_General/CustomCardTitle";
import Attachments from "../components/_General/Attachments";

export default {
    name: "Offer",
    components: {
        Attachments,
        CustomCardTitle,
        CustomCard, CreateAgreementDialog, ExpandCard, PageLoader, PageTitle, PageDetailsHeader},
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
            setBreadcrumbs: 'helpers/setBreadcrumbs',
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
            this.setBreadcrumbs([
                {text: 'Panel', to: {name: 'panel'}, exact: true},
                {text: 'Oferty', to: {name: 'offers'}, exact: true},
                {text: this.offer.name, to: {name: 'offer', params: {slug: this.offer.slug}}},
            ]);
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
