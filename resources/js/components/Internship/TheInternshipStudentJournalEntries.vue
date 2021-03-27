<template>
    <v-card elevation="0" color="card-background" :loading="loadingStudentJournalEntries">
        <template slot="progress">
            <v-progress-linear color="primary" indeterminate></v-progress-linear>
        </template>
        <v-list color="card-background">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="text-h5 font-weight-medium">Wpisy</v-list-item-title>
                    <v-list-item-subtitle>Lista wpisów wybranego studenta.</v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-action>
                    <v-btn-toggle dense borderless>
                        <the-internship-create-student-journal-entry-dialog></the-internship-create-student-journal-entry-dialog>
                        <v-btn
                            icon
                            @click="show = !show"
                            v-if="this.$route.params.studentIndex && !loadingStudentJournalEntries && studentJournalEntries.length > 0"
                        >
                            <v-icon>{{ show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                        </v-btn>
                    </v-btn-toggle>
                </v-list-item-action>
            </v-list-item>
        </v-list>
        <v-divider></v-divider>
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
    </v-card>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import InternshipStudentJournalEntry from "./InternshipStudentJournalEntry";
import TheInternshipCreateStudentJournalEntryDialog from "./TheInternshipCreateStudentJournalEntryDialog";

export default {
    name: "TheInternshipStudentJournalEntries",
    components: {TheInternshipCreateStudentJournalEntryDialog, InternshipStudentJournalEntry},
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
            studentJournalEntries: 'student/studentJournalEntries',
            loadingStudentJournalEntries: 'student/loadingStudentJournalEntries',
        }),

        displayedJournalEntries() {
            return this.studentJournalEntries.slice((this.page - 1) * this.perPage, this.page * this.perPage);
        },
    },

    methods: {
        ...mapActions({
            fetchStudentJournalEntries: 'student/fetchStudentJournalEntries'
        }),
    },

    created() {
        if (this.$route.params.studentIndex !== null) {
            this.fetchStudentJournalEntries({
                internshipId: 1,
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
