<template>
    <custom-card :loading="loadingStudentJournalEntries">
        <internship-create-journal-entry-comment-dialog
            :internship-id="$route.params.internshipId"
            :student-index="$route.params.studentIndex"
        ></internship-create-journal-entry-comment-dialog>
        <internship-update-journal-entry-dialog
            :internship-id="$route.params.internshipId"
            :student-index="$route.params.studentIndex"
            :model="dialogs['DIALOG_FIELD_CONFIRM_UPDATE_JOURNAL_ENTRIES']"
        ></internship-update-journal-entry-dialog>
        <custom-confirm-dialog
            title="Usuń wpis w dzienniku"
            :dialog-state="dialogs['DIALOG_FIELD_CONFIRM_DELETE_JOURNAL_ENTRY']"
            :toggle-function="toggleDialog"
            :confirm-function="deleteJournalEntry"
            dialog-key="DIALOG_FIELD_CONFIRM_DELETE_JOURNAL_ENTRY"
        >
            Czy na pewno chcesz usunąć ten post?
        </custom-confirm-dialog>
        <custom-confirm-dialog
            title="Usuń komentarz"
            :dialog-state="dialogs['DIALOG_FIELD_CONFIRM_DELETE_JOURNAL_ENTRIES_COMMENT']"
            :toggle-function="toggleDialog"
            :confirm-function="deleteJournalEntryComment"
            dialog-key="DIALOG_FIELD_CONFIRM_DELETE_JOURNAL_ENTRIES_COMMENT"
        >
            Czy na pewno chcesz usunąć ten komentarz?
        </custom-confirm-dialog>
        <the-internship-pdf-generate-dialog
            title="Pobierz dziennik praktyk"
            :subheader="`Dokument w formacie PDF zawierający dziennik praktyk studenta`"
            max-width="600"
            :dialog="dialogs.DIALOG_FIELD_GENERATE_STUDENT_JOURNAL"
            :internship-id="$route.params.internshipId"
            :student-index="$route.params.studentIndex"
        ></the-internship-pdf-generate-dialog>

        <custom-card-title>
            <template v-slot:default>Wpisy</template>
            <template v-slot:subheader>Lista wpisów wybranego studenta.</template>
            <template v-slot:actions>
                <v-btn
                    color="transparent"
                    @click="toggleDialog({key: 'DIALOG_FIELD_GENERATE_STUDENT_JOURNAL', val: true})"
                    v-if="$route.params.studentIndex"
                >
                    <v-icon>mdi-download</v-icon>
                </v-btn>
                <the-internship-create-student-journal-entry-dialog
                    v-if="$route.params.studentIndex && !internship.status.name.includes('ended_by_company', 'ended_by_university' , 'ended')"
                ></the-internship-create-student-journal-entry-dialog>
                <v-btn
                    icon
                    @click="show = !show"
                    v-if="$route.params.studentIndex && !loadingStudentJournalEntries && studentJournalEntries.length > 0"
                >
                    <v-icon>{{ show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                </v-btn>
            </template>
        </custom-card-title>

        <v-expand-transition
            v-if="this.$route.params.studentIndex && !loadingStudentJournalEntries && studentJournalEntries.length > 0">
            <v-row v-show="show" no-gutters>
                <v-col cols="12">
                    <v-expansion-panels flat class="component-background" accordion>
                        <internship-student-journal-entry
                            v-for="studentJournalEntry in displayedJournalEntries"
                            :key="studentJournalEntry.id"
                            :content="studentJournalEntry.content"
                            :status="studentJournalEntry.accepted"
                            :internship-start-date="internshipStartDate"
                            :journal-entry-date="studentJournalEntry.date"
                            :id="studentJournalEntry.pivot.id"
                            :user-id="studentJournalEntry.user_id"
                        ></internship-student-journal-entry>
                    </v-expansion-panels>
                </v-col>
                <v-col cols="12">
                    <v-pagination
                        light
                        v-model="page"
                        :length="Math.ceil(studentJournalEntries.length/perPage)"
                        :total-visible="totalVisible"
                    ></v-pagination>
                </v-col>
            </v-row>
        </v-expand-transition>
        <v-row v-else-if="this.$route.params.studentIndex && !loadingStudentJournalEntries">
            <v-col cols="12" class="text-center pt-8 px-10">
                <p class="text--secondary">Ten student nie dodał jeszcze wpisów do swojego dziennika praktyk.</p>
            </v-col>
        </v-row>
        <v-row v-else>
            <v-col cols="12" class="text-center pt-8">
                <p class="text--secondary">Nie wybrano studenta.</p>
            </v-col>
        </v-row>
    </custom-card>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import InternshipStudentJournalEntry from "./InternshipStudentJournalEntry";
import TheInternshipCreateStudentJournalEntryDialog from "./TheInternshipCreateStudentJournalEntryDialog";
import CustomCard from "../_General/CustomCard";
import CustomCardTitle from "../_General/CustomCardTitle";
import TheInternshipPdfGenerateDialog from "./TheInternshipPdfGenerateDialog";
import InternshipCreateJournalEntryCommentDialog from "./InternshipCreateJournalEntryCommentDialog";
import CustomConfirmDialog from "../_General/CustomConfirmDialog";
import InternshipUpdateJournalEntryDialog from "./InternshipUpdateJournalEntryDialog";

export default {
    name: "TheInternshipStudentJournalEntries",
    components: {
        InternshipUpdateJournalEntryDialog,
        CustomConfirmDialog,
        InternshipCreateJournalEntryCommentDialog,
        TheInternshipPdfGenerateDialog,
        CustomCardTitle,
        CustomCard, TheInternshipCreateStudentJournalEntryDialog, InternshipStudentJournalEntry
    },
    props: ['internshipStartDate'],

    data() {
        return {
            show: true,
            page: 1,
            perPage: 5,
            totalVisible: 5,
        }
    },

    computed: {
        ...mapGetters({
            internship: 'internship/internship',
            dialogs: 'helpers/dialogs',
            dialogArgs: 'helpers/dialogsArgs',
            studentJournalEntries: 'student/studentJournalEntries',
            loadingStudentJournalEntries: 'student/loadingStudentJournalEntries',
        }),

        displayedJournalEntries() {
            return this.studentJournalEntries.slice((this.page - 1) * this.perPage, this.page * this.perPage);
        },
    },

    methods: {
        ...mapActions({
            setSnackbar: 'snackbar/setSnackbar',
            toggleDialog: 'helpers/toggleDialog',
            downloadInternshipJournal: 'internship/downloadInternshipJournal',
            fetchStudentJournalEntries: 'student/fetchStudentJournalEntries',
            fetchInternshipStudent: 'internship/fetchInternshipStudent',
            deleteStudentJournalEntry: 'journal/deleteStudentJournalEntry',
            updateStudentJournalEntry: 'journal/updateStudentJournalEntry',
            deleteStudentJournalEntryComment: 'journal/deleteStudentJournalEntryComment',
            setDialogArgs: 'helpers/setDialogArgs',
        }),

        deleteJournalEntryComment() {
            this.deleteStudentJournalEntryComment({
                internshipId: this.$route.params.internshipId,
                studentIndex: this.$route.params.studentIndex,
                studentJournalEntryId: this.dialogArgs['DIALOG_FIELD_CONFIRM_DELETE_JOURNAL_ENTRIES_COMMENT'].studentJournalEntryId,
                commentId: this.dialogArgs['DIALOG_FIELD_CONFIRM_DELETE_JOURNAL_ENTRIES_COMMENT'].commentId
            }).then((response) => {
                if (response.data) {
                    this.setSnackbar({message: 'Komentarz został usunięty!', color: 'success'});
                    this.fetchStudentJournalEntries({
                        internshipId: this.$route.params.internshipId,
                        studentIndex: this.$route.params.studentIndex
                    });
                } else {
                    this.setSnackbar({message: 'Nie udało się usunąć komentarza!', color: 'error'});
                }
            }).catch((e) => {
                this.setSnackbar({message: 'Nie udało się usunąć komentarza!', color: 'error'});
            }).finally(() => {
                this.toggleDialog({key: 'DIALOG_FIELD_CONFIRM_DELETE_JOURNAL_ENTRIES_COMMENT', val: false});
                this.setDialogArgs({key: 'DIALOG_FIELD_CONFIRM_DELETE_JOURNAL_ENTRIES_COMMENT', val: null});
            });
        },

        deleteJournalEntry() {
            this.deleteStudentJournalEntry({
                internshipId: this.$route.params.internshipId,
                studentIndex: this.$route.params.studentIndex,
                studentJournalEntryId: this.dialogArgs['DIALOG_FIELD_CONFIRM_DELETE_JOURNAL_ENTRY'],
            }).then((response) => {
                if (response.data) {
                    this.setSnackbar({message: 'Wpis został usunięty!', color: 'success'});
                    this.fetchStudentJournalEntries({
                        internshipId: this.$route.params.internshipId,
                        studentIndex: this.$route.params.studentIndex
                    });
                } else {
                    this.setSnackbar({message: 'Nie udało się usunąć wpisu!', color: 'error'});
                }
            }).catch((e) => {
                this.setSnackbar({message: 'Nie udało się usunąć wpisu!', color: 'error'});
            }).finally(() => {
                this.toggleDialog({key: 'DIALOG_FIELD_CONFIRM_DELETE_JOURNAL_ENTRY', val: false});
                this.setDialogArgs({key: 'DIALOG_FIELD_CONFIRM_DELETE_JOURNAL_ENTRY', val: null});
            });
        }
    },

    created() {
        if (this.$route.params.studentIndex !== null) {
            this.fetchInternshipStudent({
                internship: this.$route.params.internshipId,
                student: this.$route.params.studentIndex
            });

            this.fetchStudentJournalEntries({
                internshipId: this.$route.params.internshipId,
                studentIndex: this.$route.params.studentIndex
            }).then(() => {

            }).catch((e) => {
                console.error(e);
            })
        }
    }
}
</script>

<style scoped>

</style>
