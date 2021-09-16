<template>
    <v-dialog
        v-model="acceptOfferDialog"
        width="600"
    >
        <custom-card>
            <custom-card-title>
                <template v-slot:default>Akceptuj ofertę</template>
                <template v-slot:subheader>Czy chcesz zaakceptować ofertę <strong>{{ name }}</strong>?</template>
                <template v-slot:actions>
                    <v-btn icon @click="toggleAcceptDialog(false)">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </template>
            </custom-card-title>

            <custom-card-footer>
                <template v-slot:left>
                    <v-btn text @click="toggleAcceptDialog(false)" class="text--secondary">Anuluj</v-btn>
                </template>
                <template v-slot:right>
                    <v-btn outlined @click="accept" color="primary">Akceptuj</v-btn>
                </template>
            </custom-card-footer>
        </custom-card>
    </v-dialog>
</template>

<script>
import ExpandCard from "../../_Helpers/ExpandCard";
import {mapActions, mapGetters} from "vuex";
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";
import CustomCardFooter from "../../_General/CustomCardFooter";

export default {
    name: "AcceptOfferDialog",
    props: ['name', 'slug'],

    components: {CustomCardFooter, CustomCardTitle, CustomCard, ExpandCard},

    data() {
        return {
            dialog: null,
        }
    },

    computed: {
        ...mapGetters({
            acceptOfferDialog: 'helpers/acceptOfferDialog'
        }),
    },

    methods: {
        ...mapActions({
            toggleAcceptDialog: 'helpers/toggleAcceptOfferDialog',
            acceptOffer: 'offer/acceptOffer',
            setSnackbar: 'snackbar/setSnackbar',
            fetchOffers: 'offer/fetchOffers',
            fetchNumberOfNewOffers: 'statistic/fetchNumberOfNewOffers',
        }),

        accept() {
            this.acceptOffer(this.slug).then(() => {
                this.toggleAcceptDialog(false);
                this.setSnackbar({message: 'Oferta została zaakceptowana!', color: 'success'});
                this.fetchNumberOfNewOffers();
                this.fetchOffers({categories: null, statuses: ['new']});
            }).catch((e) => {
                this.toggleAcceptDialog(false);
                this.setSnackbar({message: 'Oferta nie została zaakceptowana!', color: 'error'});
            });
        }
    }
}
</script>

<style scoped>

</style>
