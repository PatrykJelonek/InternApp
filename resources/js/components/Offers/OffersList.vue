<template>
    <v-container>
        <v-data-iterator
            :items="offers"
            item-key="id"
            :items-per-page="2"
            :loading="offersLoading"
            hide-default-footer
        >
            <template v-slot:default="{ items, isExpanded, expand }">
                <offer-card
                    v-for="offer in items"
                    :key="offer.id"
                    :title="offer.name"
                    :company-name="offer.company.name"
                ></offer-card>
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
