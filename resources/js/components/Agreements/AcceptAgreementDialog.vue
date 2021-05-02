<template>
    <v-dialog
        v-model="acceptAgreementDialog"
        width="600"
    >
        <expand-card
            title="Akceptuj umowę"
            :expand="false"
        >
            <v-card-text>
                Czy chcesz akceptować umowę?
            </v-card-text>
            <v-card-actions>
                <v-row>
                    <v-col cols="6">
                        <v-btn text @click="toggleAcceptAgreementDialog(false)" class="text--secondary">Anuluj</v-btn>
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
import ExpandCard from "../_Helpers/ExpandCard";
import {mapActions, mapGetters} from "vuex";
import moment from "moment";

export default {
    name: "AcceptAgreementDialog",
    props: ['slug'],

    components: {ExpandCard},

    methods: {
        ...mapActions({
            toggleAcceptAgreementDialog: 'helpers/toggleAcceptAgreementDialog',
            acceptAgreement: 'agreement/acceptAgreement',
        }),

        accept() {
            this.acceptAgreement(this.slug).then(() => {
                this.toggleAcceptAgreementDialog(false);
            }).catch((e) => {

            });

        }
    },

    computed: {
        ...mapGetters({
            acceptAgreementDialog: 'helpers/acceptAgreementDialog',
        }),
    },
}
</script>

<style scoped>

</style>
