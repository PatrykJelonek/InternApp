<template>
    <v-dialog v-model="dialogs['DIALOG_FIELD_CREATE_JOURNAL_ENTRY_COMMENT']" max-width="600">
        <custom-card>
            <custom-card-title>
                <template v-slot:default>Nowy komentarz</template>
                <template v-slot:subheader>Formularz dodawania komentarza do wpisu w dzienniku.</template>
                <template v-slot:actions>
                    <v-btn icon @click="toggleDialog({key: 'DIALOG_FIELD_CREATE_JOURNAL_ENTRY_COMMENT', val: false})">
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
                            label="Treść komentarza"
                            placeholder="..."
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
                    <v-btn color="primary" outlined @click="submit">Dodaj komentarz</v-btn>
                </template>
            </custom-card-footer>
        </custom-card>
    </v-dialog>
</template>

<script>
import CustomCardFooter from "../_General/CustomCardFooter";
import CustomCardTitle from "../_General/CustomCardTitle";
import CustomCard from "../_General/CustomCard";
import {mapActions, mapGetters} from "vuex";
import moment from "moment";

export default {
    name: "InternshipCreateJournalEntryCommentDialog",
    components: {CustomCardFooter, CustomCardTitle, CustomCard},
    props: ['internshipId', 'studentIndex'],

    data() {
        return {
            content: null,
        }
    },

    computed: {
        ...mapGetters({
            dialogs: 'helpers/dialogs',
            dialogsArgs: 'helpers/dialogsArgs',
        })
    },

    methods: {
        ...mapActions({
            setSnackbar: 'snackbar/setSnackbar',
            toggleDialog: 'helpers/toggleDialog',
            setDialogArgs: 'helpers/setDialogArgs',
            createStudentJournalEntryComment: 'journal/createStudentJournalEntryComment',
            fetchStudentJournalEntries: 'student/fetchStudentJournalEntries',
        }),

        async submit() {
            this.createStudentJournalEntryComment({
                internshipId: this.internshipId,
                studentIndex: this.studentIndex,
                studentJournalEntryId: this.dialogsArgs['DIALOG_FIELD_CREATE_JOURNAL_ENTRY_COMMENT'],
                content: this.content,
            }).then(() => {
                this.setSnackbar({message: 'Komentarz został dodany!', color: 'success'});
                this.fetchStudentJournalEntries({
                    internshipId: this.$route.params.internshipId,
                    studentIndex: this.$route.params.studentIndex
                });
            }).catch((e) => {
                this.setSnackbar({message: 'Wystąpił problem podczas dodawania komentarza, \n skontaktuj się z administratorem!', color: 'error'});
            }).finally(() => {
                this.toggleDialog({key: 'DIALOG_FIELD_CREATE_JOURNAL_ENTRY_COMMENT', val: false});
                this.setDialogArgs({key: 'DIALOG_FIELD_CREATE_JOURNAL_ENTRY_COMMENT', val: null});
            })
        }
    },


}
</script>

<style scoped>

</style>
