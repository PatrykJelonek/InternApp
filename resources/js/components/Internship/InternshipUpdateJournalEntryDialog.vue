<template>
    <v-dialog max-width="600" v-model="model">
        <custom-card>
            <custom-card-title>
                <template v-slot:default>Nowy komentarz</template>
                <template v-slot:subheader>Formularz dodawania komentarza do wpisu w dzienniku.</template>
                <template v-slot:actions>
                    <v-btn icon @click="toggleDialog({key: 'DIALOG_FIELD_CONFIRM_UPDATE_JOURNAL_ENTRIES', val: false})">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </template>
            </custom-card-title>

            <v-form class="pa-5">
                <v-row>
                    <v-col cols="12">
                        <v-textarea
                            v-model="content"
                            outlined
                            label="Treść wpisu"
                            dense
                            rows="5"
                            hide-details="auto"
                            persistent-hint
                        ></v-textarea>
                    </v-col>
                </v-row>
            </v-form>

            <custom-card-footer>
                <template v-slot:right>
                    <v-btn color="primary" outlined @click="submit">Zapisz</v-btn>
                </template>
            </custom-card-footer>
        </custom-card>
    </v-dialog>
</template>

<script>
import CustomCard from "../_General/CustomCard";
import CustomCardTitle from "../_General/CustomCardTitle";
import CustomCardFooter from "../_General/CustomCardFooter";
import {mapActions, mapGetters} from "vuex";

export default {
    name: "InternshipUpdateJournalEntryDialog",
    components: {CustomCardFooter, CustomCardTitle, CustomCard},

    props: ['internshipId', 'studentIndex', 'model'],

    data() {
        return {
            content: null,
            date: null,
        }
    },

    computed: {
        ...mapGetters({
            dialogs: 'helpers/dialogs',
            dialogsArgs: 'helpers/dialogsArgs'
        }),
    },

    methods: {
        ...mapActions({
            toggleDialog: 'helpers/toggleDialog',
            setDialogArgs: 'helpers/setDialogArgs',
            updateStudentJournalEntry: 'journal/updateStudentJournalEntry',
        }),

        submit() {
            this.updateStudentJournalEntry(
                {
                    internshipId: this.internshipId,
                    studentIndex: this.studentIndex,
                    studentJournalEntryId: this.dialogsArgs['DIALOG_FIELD_CONFIRM_UPDATE_JOURNAL_ENTRIES'].studentJournalEntryId,
                    content: this.content,
                }
            ).then((response) => {

            }).catch((e) => {

            }).finally(() => {
                this.toggleDialog({key: 'DIALOG_FIELD_CONFIRM_UPDATE_JOURNAL_ENTRIES', val: false});
                this.setDialogArgs({key: 'DIALOG_FIELD_CONFIRM_UPDATE_JOURNAL_ENTRIES', val: false});
            })
        },
    },

    watch: {
        model(newVal, oldVal) {
            this.content = this.dialogsArgs['DIALOG_FIELD_CONFIRM_UPDATE_JOURNAL_ENTRIES'] ? this.dialogsArgs['DIALOG_FIELD_CONFIRM_UPDATE_JOURNAL_ENTRIES'].content : null;
        }
    }
}
</script>

<style scoped>

</style>
