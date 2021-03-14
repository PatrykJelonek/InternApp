<template>
    <v-container fluid>
        <the-internship-students-drawer></the-internship-students-drawer>
        <v-row>
            <v-col cols="12" md="6" lg="4">
                <the-internship-info-card
                    :internship-name="internship.agreement.program"
                    :internship-start-date="internship.agreement.date_from"
                    :internship-end-date="internship.agreement.date_to"
                ></the-internship-info-card>
            </v-col>
        </v-row>
        <!-- Students -->
        <v-row class="mt-10">
            <v-col
                cols="12"
                md="4"
                lg="3"
                v-has="['admin','company_worker','university_worker']"
            >
                <v-expansion-panels v-model="studentListExpansionPanel" flat>
                    <v-expansion-panel class="transparent">
                        <internship-column-header
                            icon="mdi-account-group-outline"
                            title="Studenci"
                        ></internship-column-header>
                        <v-expansion-panel-content color="transparent">
                            <the-internship-students-list
                                :internship-id="$route.params.internshipId"
                                :internship-end-date="internship.agreement.date_to"
                            ></the-internship-students-list>
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-expansion-panels>
            </v-col>
            <!-- Journal Entries -->
            <v-col cols="12" md="4" lg="3">
                <v-expansion-panels v-model="journalEntriesExpansionPanel" flat>
                    <v-expansion-panel class="transparent">
                        <internship-column-header
                            icon="mdi-text-box-multiple-outline"
                            title="Wpisy"
                        ></internship-column-header>
                        <v-expansion-panel-content class="transparent">
                            <internship-dialog name="JOURNAL_ENTRY_DIALOG">
                                <internship-create-journal-entry-form
                                    :internship-end-date="internship.agreement.date_to"
                                    dialog-name="JOURNAL_ENTRY_DIALOG"
                                ></internship-create-journal-entry-form>
                            </internship-dialog>
                            <the-internship-student-journal-entries-list
                                :internship-start-date="internship.agreement.date_from"
                            ></the-internship-student-journal-entries-list>
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-expansion-panels>
            </v-col>
            <!-- Tasks -->
            <v-col cols="12" md="4" lg="3">
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
            <v-col cols="12" lg="3" class="hidden-md-and-down">
                <v-expansion-panels v-model="previewExpansionPanel" flat>
                    <v-expansion-panel class="transparent">
                        <internship-column-header
                            icon="mdi-eye-outline"
                            title="Podgląd"
                        ></internship-column-header>
                        <v-expansion-panel-content class="transparent">
                            <p>{{preview}}</p>
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-expansion-panels>
            </v-col>
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

    export default {
        name: "Internship",
        components: {
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
                fetchInternship: 'internship/fetchInternship'
            }),
        },

        created() {
            this.fetchInternship(this.$route.params.internshipId).then(() => {
                this.showInfoCard = true;
            }).catch((e) => {
               console.error(e);
            });




            // if(this.currentUser.roles.find((role) => {
            //     return role.name.toLowerCase() === 'student';
            // })) {
            //     this.fetchJournalEntries({internshipId: 2, studentId: 3}).then(() => {
            //         console.log('MAMY TO');
            //     }).catch((e) => {
            //         console.error("DUMP");
            //     });
            // }
        }
    }
</script>

<style scoped>

</style>
