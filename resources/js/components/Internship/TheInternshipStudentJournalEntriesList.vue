<template>
    <div>
        <template v-if="$route.params.studentIndex">
            <template v-if="studentJournalEntries.length > 0 && !loadingStudentJournalEntries">
                <internship-student-journal-entries-list-item
                    v-for="studentJournalEntry in studentJournalEntries"
                    :key="studentJournalEntry.id"
                    :internship-start-date="internshipStartDate"
                    :journal-entry-date="studentJournalEntry.created_at"
                    :content="studentJournalEntry.content"
                ></internship-student-journal-entries-list-item>
            </template>
            <template v-else-if="loadingStudentJournalEntries">
                <div class="d-flex justify-center mt-5">
                    <v-progress-circular
                        indeterminate
                        color="#262A34"
                        size="60"
                    ></v-progress-circular>
                </div>
            </template>
            <template v-else>
                <h4 class="text-center">Wybrany student nie posiada wpisów w&nbsp;dzienniku!</h4>
            </template>
        </template>
        <template v-else>
            <h4 class="text-center">Nie wybrano studenta!</h4>
        </template>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";
    import InternshipStudentJournalEntriesListItem from "./InternshipStudentJournalEntriesListItem";

    export default {
        name: "TheInternshipStudentJournalEntriesList",
        props: ['internshipStartDate'],

        components: {InternshipStudentJournalEntriesListItem},

        computed: {
            ...mapGetters({
                studentJournalEntries: 'student/studentJournalEntries',
                loadingStudentJournalEntries: 'student/loadingStudentJournalEntries',
            })
        },

        methods: {
            ...mapActions({
                fetchStudentJournalEntries: 'student/fetchStudentJournalEntries'
            }),
        },

        created() {
            if(this.$route.params.studentIndex !== null) {
                this.fetchStudentJournalEntries({internshipId: 1, studentIndex: this.$route.params.studentIndex}).then(() => {

                }).catch((e) => {
                    console.error(e);
                })
            }
        }
    }
</script>

<style scoped>

</style>
