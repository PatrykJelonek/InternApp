<template>
    <v-container fluid>
        <!--        <the-internship-students-drawer v-if="!$vuetify.breakpoint.mobile"></the-internship-students-drawer>-->
        <page-title>{{ internship.offer.name }}</page-title>
        <v-row>
            <v-col cols="12" md="6" lg="12">
                <the-internship-info-card
                    :internship-name="internship.offer.name"
                    :internship-start-date="internship.agreement.date_from"
                    :internship-end-date="internship.agreement.date_to"
                    :university-id="internship.agreement.university.id"
                    :university-name="internship.agreement.university.name"
                    :company-id="internship.agreement.company.id"
                    :company-name="internship.agreement.company.name"
                ></the-internship-info-card>
            </v-col>
        </v-row>
        <v-row class="mt-10 mb-8">
            <v-col cols="12">
                <the-internship-students></the-internship-students>
            </v-col>
        </v-row>
        <!-- Students -->
        <v-row class="mb-10">
            <!-- Journal Entries -->
            <v-col cols="12" md="4" lg="6">
                <the-internship-student-journal-entries
                    :internship-start-date="internship.agreement.date_from"
                ></the-internship-student-journal-entries>
            </v-col>
            <!-- Tasks -->
            <v-col cols="12" md="4" lg="6">
                <v-expansion-panels v-model="tasksExpansionPanel" flat>
                    <v-expansion-panel class="transparent">
                        <internship-column-header
                            icon="mdi-calendar-check"
                            title="Zadania"
                        ></internship-column-header>
                        <v-expansion-panel-content class="transparent">
                            <internship-dialog name="TASK_DIALOG">
                                <internship-create-task-form
                                    dialogName="TASK_DIALOG"
                                ></internship-create-task-form>
                            </internship-dialog>
                            <!--                            <the-internship-create-student-task-dialog></the-internship-create-student-task-dialog>-->
                            <the-internship-student-tasks-list></the-internship-student-tasks-list>
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-expansion-panels>
            </v-col>
            <!-- Preview -->
<!--            <v-col cols="12" lg="auto" class="hidden-md-and-down">-->
<!--                <v-expansion-panels v-model="previewExpansionPanel" flat>-->
<!--                    <v-expansion-panel class="transparent">-->
<!--                        <internship-column-header-->
<!--                            icon="mdi-eye-outline"-->
<!--                            title="Podgląd"-->
<!--                        ></internship-column-header>-->
<!--                        <v-expansion-panel-content class="transparent">-->
<!--                            <p>{{ preview }}</p>-->
<!--                        </v-expansion-panel-content>-->
<!--                    </v-expansion-panel>-->
<!--                </v-expansion-panels>-->
<!--            </v-col>-->
        </v-row>
        <snackbar></snackbar>
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

export default {
    name: "Internship",
    components: {
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
            showInfoCard: false,
        }
    },

    computed: {
        ...mapGetters({
            currentUser: 'auth/user',
            internship: 'internship/internship',
            preview: 'internship/preview',
        })
    },

    methods: {
        ...mapActions({
            fetchInternship: 'internship/fetchInternship',
            fetchInternshipStudents: 'internship/fetchInternshipStudents',
        }),
    },

    created() {
        this.fetchInternship(this.$route.params.internshipId).then(() => {
            this.fetchInternshipStudents(this.$route.params.internshipId).then(() => {
            }).catch((e) => {
                console.error(e);
            });
            this.showInfoCard = true;

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
