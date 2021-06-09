<template>
    <v-container fluid>
        <v-data-iterator
            :items="offers"
            item-key="id"
            :items-per-page="10"
            :loading="offersLoading"
            locale="pl-PL"
        >
            <template v-slot:default="{ items, isExpanded, expand }">
                <v-row>
                    <v-col cols="3" v-for="offer in items"
                           :key="offer.id">
                        <offer-card
                            :title="offer.name"
                            :company-name="offer.company.name"
                            :created-at="offer.created_at"
                            :city="offer.company.city.name"
                            :interview="offer.interview"
                            :category-name="offer.category.display_name"
                            :program="offer.program"
                            :date-from="offer.date_from"
                            :date-to="offer.date_to"
                        ></offer-card>
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

export default {
    name: "OffersList",
    components: {OfferCard, CustomCard, CreateAgreementDialog, ExpandCard},
    data() {
        return {
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
