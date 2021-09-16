<template>
    <v-dialog
        v-model="rejectOfferDialog"
        width="600"
    >
        <custom-card>
            <custom-card-title>
                <template v-slot:default>Odrzuć Ofertę</template>
                <template v-slot:subheader>Czy chcesz odrzucić ofertę <strong>{{ name }}</strong>?</template>
                <template v-slot:actions>
                    <v-btn icon @click="toggleRejectDialog(false)">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </template>
            </custom-card-title>

            <v-row no-gutters>
                <v-col cols="12" class="pa-5">
                    <validation-observer ref="observer" v-slot="{ validate }">
                        <validation-provider
                            vid="reason"
                            rules="required"
                            v-slot="{ errors }"
                        >
                            <v-textarea
                                outlined
                                v-model="reason"
                                label="Powód odrzucenia"
                                required
                                hide-details="auto"
                                :error-messages="errors"
                            ></v-textarea>
                        </validation-provider>
                    </validation-observer>
                </v-col>
            </v-row>

            <custom-card-footer>
                <template v-slot:left>
                    <v-btn text @click="toggleRejectDialog(false)" class="text--secondary">Anuluj</v-btn>
                </template>
                <template v-slot:right>
                    <v-btn outlined @click="reject" color="primary">Odrzuć</v-btn>
                </template>
            </custom-card-footer>
        </custom-card>
    </v-dialog>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import ExpandCard from "../../_Helpers/ExpandCard";
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";
import CustomCardFooter from "../../_General/CustomCardFooter";
import {setInteractionMode, ValidationProvider, ValidationObserver} from "vee-validate";

setInteractionMode('eager');

export default {
    name: "RejectOfferDialog",
    props: ['name', 'slug'],

    components: {CustomCardFooter, CustomCardTitle, CustomCard, ExpandCard, ValidationProvider, ValidationObserver},

    data() {
        return {
            dialog: null,
            reason: null,
        }
    },

    computed: {
        ...mapGetters({
            rejectOfferDialog: 'helpers/rejectOfferDialog'
        }),
    },

    methods: {
        ...mapActions({
            toggleRejectDialog: 'helpers/toggleRejectOfferDialog',
            rejectOffer: 'offer/rejectOffer',
            setSnackbar: 'snackbar/setSnackbar',
            fetchOffers: 'offer/fetchOffers',
            fetchNumberOfNewOffers: 'statistic/fetchNumberOfNewOffers',
        }),

        async reject() {
            await this.$refs.observer.validate().then((isValid) => {
                if (isValid) {
                    this.rejectOffer({slug: this.slug, reason: this.reason}).then(() => {
                        this.toggleRejectDialog(false);
                        this.setSnackbar({message: 'Oferta została odrzucona!', color: 'success'});
                        this.reason = null;
                        this.fetchNumberOfNewOffers();
                        this.fetchOffers({categories: null, statuses: ['new']});
                    }).catch((e) => {
                        this.toggleRejectDialog(false);
                        this.setSnackbar({message: 'Oferta nie została odrzucona!', color: 'error'});
                    });
                }
            });
        }
    }
}
</script>

<style scoped>

</style>
