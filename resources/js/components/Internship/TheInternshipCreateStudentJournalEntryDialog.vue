<template>
    <div>
        <v-card
            class="pa-3 mb-3 text-center"
            color="cardBackground"
            @click="toggle"
            elevation="0"
            ripple
        >
            <v-icon>mdi-plus</v-icon>
        </v-card>
        <!-- dialog -->
        <v-dialog v-model="dialog" max-width="500">
            <v-card color="cardBackground" class="pa-5">
                <internship-create-journal-entry-form
                    :internship-end-date="internshipEndDate"
                ></internship-create-journal-entry-form>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import InternshipDialogActivator from "../_Helpers/InternshipDialogActivator";
import InternshipCreateJournalEntryForm from "./InternshipCreateJournalEntryForm";

export default {
    name: "TheInternshipCreateStudentJournalEntryDialog",
    props: ['internshipEndDate'],
    components: {InternshipCreateJournalEntryForm, InternshipDialogActivator},

    computed: {
        ...mapGetters({
            dialog: 'helpers/dialog',
        })
    },

    methods: {
        ...mapActions({
            toggleDialog: 'helpers/toggleDialog'
        }),

        toggle() {
            this.toggleDialog();
        }
    }
}
</script>

<style scoped>

</style>
