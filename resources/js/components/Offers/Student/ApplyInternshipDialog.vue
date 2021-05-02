<template>
    <v-dialog
        v-model="applyInternshipDialog"
        width="600"
    >
        <expand-card
            title="Aplikuj na praktykę"
            :expand="false"
        >
            <v-card-text>
                Czy chcesz aplikować na praktykę: <strong>{{ agreement.name }}</strong>
            </v-card-text>
            <v-card-actions>
                <v-row>
                    <v-col cols="6">
                        <v-btn text @click="toggleApplyInternshipDialog(false)" class="text--secondary">Anuluj</v-btn>
                    </v-col>
                    <v-col cols="6" class="text-right">
                        <v-btn outlined @click="apply" color="primary">Aplikuj</v-btn>
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
    name: "ApplyInternshipDialog",
    props: ['agreement'],

    components: {ExpandCard},

    methods: {
        ...mapActions({
            toggleApplyInternshipDialog: 'helpers/toggleApplyInternshipDialog',
            createInternship: 'internship/create',
            setSnackbar: 'snackbar/setSnackbar',
            parseErrorMessage: 'helpers/parseErrorMessage',
        }),

        async apply() {
            await this.createInternship({
                offerId: this.agreement.offer.id,
                agreementId: this.agreement.id,
                companySupervisorId: this.agreement.offer.company_supervisor_id,
                universitySupervisorId: this.agreement.university_supervisor_id,
            }).then(() => {
                this.toggleApplyInternshipDialog(false);
                this.setSnackbar({message: 'Twoja aplikacja została wysłana!', color: 'success'});
            }).catch((e) => {
                this.toggleApplyInternshipDialog(false);
                if(e.response.status !== 403) {
                    this.parseErrorMessage(e.response.status);
                    this.setSnackbar({message: this.errorMessage, color: 'error'});
                } else {
                    this.setSnackbar({message: 'Nie możesz już aplikować na praktyki.', color: 'error'});
                }
            });
        },
    },

    computed: {
        ...mapGetters({
            applyInternshipDialog: 'helpers/applyInternshipDialog',
            errorMessage: 'helpers/errorMessage'
        }),
    },
}
</script>

<style scoped>

</style>
