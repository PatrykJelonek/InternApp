<template>
    <custom-card :loading="loadingStudentJournalEntries">
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
            <v-row v-show="show">
                <v-col cols="12">
                    <v-list nav color="card-background">
                        <internship-student-journal-entry
                            v-for="studentJournalEntry in displayedJournalEntries"
                            :key="studentJournalEntry.id"
                            :content="studentJournalEntry.content"
                            :status="studentJournalEntry.accepted"
                            :internship-start-date="internshipStartDate"
                            :journal-entry-date="studentJournalEntry.date"
                        ></internship-student-journal-entry>
                    </v-list>
                </v-col>
                <v-col cols="12">
                    <v-pagination
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

export default {
    name: "TheInternshipStudentJournalEntries",
    components: {
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
            studentJournalEntries: 'student/studentJournalEntries',
            loadingStudentJournalEntries: 'student/loadingStudentJournalEntries',
        }),

        displayedJournalEntries() {
            return this.studentJournalEntries.slice((this.page - 1) * this.perPage, this.page * this.perPage);
        },
    },

    methods: {
        ...mapActions({
            toggleDialog: 'helpers/toggleDialog',
            downloadInternshipJournal: 'internship/downloadInternshipJournal',
            fetchStudentJournalEntries: 'student/fetchStudentJournalEntries',
            fetchInternshipStudent: 'internship/fetchInternshipStudent',
        }),
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
