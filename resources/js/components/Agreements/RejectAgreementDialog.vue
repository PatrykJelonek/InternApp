<template>
    <v-dialog
        v-model="rejectAgreementDialog"
        width="600"
    >
        <expand-card
            title="Odrzuć umowę"
            :expand="false"
        >
            <v-card-text>
                Czy chcesz odrzucić umowę?
            </v-card-text>
            <v-card-actions>
                <v-row>
                    <v-col cols="6">
                        <v-btn text @click="toggleRejectAgreementDialog(false)" class="text--secondary">Anuluj</v-btn>
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
import ExpandCard from "../_Helpers/ExpandCard";
import {mapActions, mapGetters} from "vuex";

export default {
    name: "RejectAgreementDialog",
    props: ['slug'],

    components: {ExpandCard},

    methods: {
        ...mapActions({
            toggleRejectAgreementDialog: 'helpers/toggleRejectAgreementDialog',
            rejectAgreement: 'agreement/rejectAgreement',
        }),

        reject() {
            this.rejectAgreement()
        }
    },

    computed: {
        ...mapGetters({
            rejectAgreementDialog: 'helpers/rejectAgreementDialog',
        }),
    },
}
</script>

<style scoped>

</style>
