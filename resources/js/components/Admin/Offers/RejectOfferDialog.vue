<template>
    <v-dialog
        v-model="rejectOfferDialog"
        width="600"
    >
        <expand-card
            title="Odrzuć Ofertę"
            :expand="false"
        >
            <v-card-text>
                Czy chcesz odrzucić ofertę <strong>{{ name }}</strong>?
            </v-card-text>
            <v-card-actions>
                <v-row>
                    <v-col cols="6">
                        <v-btn text @click="toggleRejectDialog(false)" class="text--secondary">Anuluj</v-btn>
                    </v-col>
                    <v-col cols="6" class="text-right">
                        <v-btn outlined @click="reject" color="error">Odrzuć</v-btn>
                    </v-col>
                </v-row>
            </v-card-actions>
        </expand-card>
    </v-dialog>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import ExpandCard from "../../_Helpers/ExpandCard";

export default {
    name: "RejectOfferDialog",
    props: ['name', 'slug'],

    components: {ExpandCard},

    data() {
        return {
            dialog: null,
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
            setSnackbar: 'snackbar/setSnackbar'
        }),

        reject() {
            this.rejectOffer(this.slug).then(() => {
                this.toggleRejectDialog(false);
                this.setSnackbar({message: 'Oferta została odrzucona!', color: 'success'});
            }).catch((e) => {
                this.toggleRejectDialog(false);
                this.setSnackbar({message: 'Oferta nie została odrzucona!', color: 'error'});
            });
        }
    }
}
</script>

<style scoped>

</style>
