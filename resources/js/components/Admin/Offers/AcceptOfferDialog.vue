<template>
    <v-dialog
        v-model="acceptOfferDialog"
        width="600"
    >
        <expand-card
            title="Akceptuj Ofertę"
            :expand="false"
        >
            <v-card-text>
                Czy chcesz akceptować ofertę <strong>{{ name }}</strong>?
            </v-card-text>
            <v-card-actions>
                <v-row>
                    <v-col cols="6">
                        <v-btn text @click="toggleAcceptDialog(false)" class="text--secondary">Anuluj</v-btn>
                    </v-col>
                    <v-col cols="6" class="text-right">
                        <v-btn outlined @click="accept" color="primary">Akceptuj</v-btn>
                    </v-col>
                </v-row>
            </v-card-actions>
        </expand-card>
    </v-dialog>
</template>

<script>
import ExpandCard from "../../_Helpers/ExpandCard";
import {mapActions, mapGetters} from "vuex";

export default {
    name: "AcceptOfferDialog",
    props: ['name', 'slug'],

    components: {ExpandCard},

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
            setSnackbar: 'snackbar/setSnackbar'
        }),

        accept() {
            this.acceptOffer(this.slug).then(() => {
                this.toggleAcceptDialog(false);
                this.setSnackbar({message: 'Oferta została zaakceptowana!', color: 'success'});
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
