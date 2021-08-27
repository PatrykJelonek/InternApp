<template>
    <v-dialog
        v-model="acceptOfferDialog"
        width="600"
    >
        <custom-card
            title="Akceptuj Ofertę"
            :expand="false"
        >
            <custom-card-title>
                <template v-slot:default>Akceptuj ofertę</template>
            </custom-card-title>
            <v-row no-gutters class="pa-5">
                <v-col cols="12">
                    Czy chcesz akceptować ofertę <strong>{{ name }}</strong>?
                </v-col>
            </v-row>
            <v-divider></v-divider>
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
        </custom-card>
    </v-dialog>
</template>

<script>
import ExpandCard from "../../_Helpers/ExpandCard";
import {mapActions, mapGetters} from "vuex";
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";

export default {
    name: "AcceptOfferDialog",
    props: ['name', 'slug'],

    components: {CustomCardTitle, CustomCard, ExpandCard},

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
