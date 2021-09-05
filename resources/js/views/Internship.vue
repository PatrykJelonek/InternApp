<template>
    <v-container fluid class="pa-0">
        <div v-if="!internshipLoading">
            <internship-summary-dialog
                :internship-students="internshipStudents"
                :internship-id="internship.id"
                v-if="!internshipStudentsLoading && internshipStudents.length > 0"
            ></internship-summary-dialog>

            <!--        <the-internship-students-drawer v-if="!$vuetify.breakpoint.mobile"></the-internship-students-drawer>-->
            <page-title>
                <template v-slot:default>
                    {{ internship.agreement.name }}
                    <v-tooltip bottom color="component-background">
                        <template v-slot:activator="{ on, attrs }">
                            <v-chip
                                small
                                outlined
                                v-on="on"
                                v-bind="attrs"
                            >{{ internship.status.display_name }}</v-chip>
                        </template>
                        <span>Status praktyki</span>
                    </v-tooltip>
                </template>
                <template v-slot:actions>
                    <v-btn
                        color="primary"
                        outlined
                        @click="toggleDialog({key: 'DIALOG_FIELD_INTERNSHIP_SUMMARY', val: true})"
                    >
                        Zakończ praktykę
                    </v-btn>
                </template>
            </page-title>
            <v-row align="start">
                <v-col cols="12" md="12" lg="12">
                    <the-internship-info-card
                        :internship-name="internship.agreement.name"
                        :internship-start-date="internship.agreement.date_from"
                        :internship-end-date="internship.agreement.date_to"
                        :university-slug="internship.agreement.university.slug"
                        :university-name="internship.agreement.university.name"
                        :company-slug="internship.agreement.company.slug"
                        :company-name="internship.agreement.company.name"
                    ></the-internship-info-card>
                </v-col>
                <!-- Students -->
                <v-col
                    cols="12"
                    class="my-2"
                >
                    <the-internship-students></the-internship-students>
                </v-col>

                <!-- Journal Entries -->
                <v-col cols="12" md="6" lg="6" class="my-2">
                    <the-internship-student-journal-entries
                        :internship-start-date="internship.agreement.date_from"
                    ></the-internship-student-journal-entries>
                </v-col>
                <!-- Tasks -->
                <v-col cols="12" md="6" lg="6" class="my-2">
                    <the-internship-student-tasks></the-internship-student-tasks>
                </v-col>
            </v-row>
            <snackbar></snackbar>
        </div>
        <div v-else class="mt-15 text-center">
            <v-progress-circular
                indeterminate
                size="100"
                width="8"
                color="primary"
            ></v-progress-circular>
        </div>
    </v-container>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import TheInternshipInfoCard from "../components/Internship/TheInternshipInfoCard";
import InternshipColumnHeader from "../components/Internship/InternshipColumnHeader";
import TheInternshipStudentsList from "../components/Internship/TheInternshipStudentsList";
import TheJournalEntriesList from "../components/Journals/TheJournalEntriesList";
import TheInternshipStudentJournalEntriesList
    from "../components/Internship/TheInternshipStudentJournalEntriesList";
import TheInternshipStudentTasksList from "../components/Internship/TheInternshipStudentTasksList";
import TheInternshipActions from "../components/Internship/TheInternshipActions";
import TheInternshipCreateStudentJournalEntryDialog
    from "../components/Internship/TheInternshipCreateStudentJournalEntryDialog";
import TheInternshipCreateStudentTaskDialog from "../components/Internship/TheInternshipCreateStudentTaskDialog";
import Snackbar from "../components/_Helpers/Snackbar";
import InternshipDialog from "../components/Internship/InternshipDialog";
import InternshipCreateJournalEntryForm from "../components/Internship/InternshipCreateJournalEntryForm";
import InternshipCreateTaskForm from "../components/Internship/InternshipCreateTaskForm";
import TheInternshipStudentsDrawer from "../components/Internship/TheInternshipStudentsDrawer";
import PageTitle from "../components/_Helpers/PageTitle";
import TheInternshipStudents from "../components/Internship/TheInternshipStudents";
import TheInternshipPercent from "../components/Internship/TheInternshipPercent";
import TheInternshipStudentJournalEntries from "../components/Internship/TheInternshipStudentJournalEntries";
import TheInternshipFab from "../components/Internship/TheInternshipFab";
import TheInternshipStudentTasks from "../components/Internship/TheInternshipStudentTasks";
import InternshipSummaryDialog from "../components/Internship/InternshipSummaryDialog";

export default {
    name: "Internship",
    components: {
        InternshipSummaryDialog,
        TheInternshipStudentTasks,
        TheInternshipFab,
        TheInternshipStudentJournalEntries,
        TheInternshipPercent,
        TheInternshipStudents,
        PageTitle,
        TheInternshipStudentsDrawer,
        InternshipCreateTaskForm,
        InternshipCreateJournalEntryForm,
        InternshipDialog,
        Snackbar,
        TheInternshipCreateStudentTaskDialog,
        TheInternshipCreateStudentJournalEntryDialog,
        TheInternshipActions,
        TheInternshipStudentTasksList,
        TheInternshipStudentJournalEntriesList,
        TheJournalEntriesList,
        TheInternshipStudentsList,
        InternshipColumnHeader,
        TheInternshipInfoCard
    },

    data() {
        return {
            studentListExpansionPanel: 0,
            journalEntriesExpansionPanel: 0,
            tasksExpansionPanel: 0,
            previewExpansionPanel: 0,
            showPage: false,
        }
    },

    computed: {
        ...mapGetters({
            internshipStudents: 'internship/internshipStudents',
            internshipStudentsLoading: 'internship/internshipStudentsLoading',
            currentUser: 'auth/user',
            internship: 'internship/internship',
            preview: 'internship/preview',
            internshipLoading: 'internship/internshipLoading',
        })
    },

    methods: {
        ...mapActions({
            toggleDialog: 'helpers/toggleDialog',
            fetchInternship: 'internship/fetchInternship',
            fetchInternshipStudents: 'internship/fetchInternshipStudents',
            setBreadcrumbs: 'helpers/setBreadcrumbs',
            downloadInternshipJournal: 'internship/downloadInternshipJournal'
        }),
    },

    created() {
        this.fetchInternship(this.$route.params.internshipId).then(() => {
            this.setBreadcrumbs([
                {text: 'Panel', to: {name: 'panel'}, exact: true},
                {text: 'Praktyki i Staże', to: {name: 'admin'}, exact: true},
                {
                    text: this.internship.agreement.name ?? '',
                    to: {name: 'internship', params: {internshipId: this.internship.id}},
                    exact: true
                },
            ]);

            this.fetchInternshipStudents(this.$route.params.internshipId).then(() => {

            }).catch((e) => {
                console.error(e);
            });

            if (this.internship.length < 1) {
                this.$router.push({name: 'not-found'});
            }
        }).catch((e) => {
            console.error(e);
        });
    }
}
</script>

<style scoped>

</style>
