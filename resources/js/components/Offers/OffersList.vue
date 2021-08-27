<template>
    <v-container fluid class="pa-0">
        <create-agreement-dialog></create-agreement-dialog>

        <custom-card class="mb-5">
            <v-row no-gutters>
                <v-col cols="12">
                    <v-text-field
                        outlined
                        prepend-inner-icon="mdi-magnify"
                        hide-details
                        v-model="search"
                        label="Szukaj"
                    ></v-text-field>
                </v-col>
            </v-row>
        </custom-card>

        <v-data-iterator
            :items="offers"
            item-key="id"
            :items-per-page="10"
            :loading="offersLoading"
            locale="pl-PL"
            :search="search"
        >
            <template v-slot:default="{ items, isExpanded, expand }">
                <v-row>
                    <v-col
                        cols="12"
                        v-for="offer in items"
                        :key="offer.id"
                    >
                        <offers-list-row
                            :name="offer.name"
                            :address="offer.company.full_address"
                            :category="offer.category.display_name"
                            :interview="offer.interview"
                            :company-name="offer.company.name"
                            :date-range="formatDate(offer.date_from) + ' - ' + formatDate(offer.date_to)"
                            :logo-url="offer.company.logo_url"
                            :slug="offer.slug"
                            :offer="offer"
                        ></offers-list-row>
                    </v-col>
                </v-row>
            </template>

            <template v-slot:loading>
                <v-row>
                    <v-col cols="12" class="text-center">
                        <v-progress-circular color="primary" size="80" indeterminate></v-progress-circular>
                    </v-col>
                </v-row>
            </template>
        </v-data-iterator>
    </v-container>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import moment from "moment";
import ExpandCard from "../_Helpers/ExpandCard";
import CreateAgreementDialog from "../Agreements/CreateAgreementDialog";
import CustomCard from "../_General/CustomCard";
import OfferCard from "./OfferCard";
import OffersListRow from "./OffersListRow";
import CreateInternshipDialog from "./Student/CreateInternshipDialog";

export default {
    name: "OffersList",
    components: {CreateInternshipDialog, OffersListRow, OfferCard, CustomCard, CreateAgreementDialog, ExpandCard},
    data() {
        return {
            search: null,
            show: true,
            selectedOffer: null,
            headers: [
                {text: 'Nazwa', value: 'name'},
                {text: 'Kategoria', value: 'category'},
                {text: 'Firma', value: 'company'},
                {text: 'Miejsca', value: 'places_number'},
                {text: 'Od', value: 'date_from'},
                {text: 'Do', value: 'date_to'},
                {text: 'Interview', value: 'interview'},
                {text: 'Dodano', value: 'created_at'},
                {text: 'Akcje', value: 'actions'},
            ],
        }
    },

    computed: {
        ...mapGetters({
            offers: 'offer/offers',
            offersLoading: 'offer/offersLoading',
        }),
    },

    methods: {
        ...mapActions({
            fetchOffers: 'offer/fetchOffers',
            toggleCreateAgreementDialog: 'helpers/toggleCreateAgreementDialog',
            toggleDialog: 'helpers/toggleCreateInternshipDialog',
        }),

        setSelectedOffer(offer) {
            this.selectedOffer = offer;
        },

        formatDate(date) {
            if (date) {
                return moment(date).format('DD.MM.YYYY');
            }

            return '---';
        },
    },

    created() {
        this.fetchOffers({categories: null, statuses: ['accepted'], onlyWithPlaces: true}).then(() => {
            this.isLoading = false;
        });
    }
}
</script>

<style lang="scss">
.table-cursor tbody tr:hover {
    cursor: pointer;
}

.cursor-pointer {
    cursor: pointer;
}
</style>
