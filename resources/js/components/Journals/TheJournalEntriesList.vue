<template>
    <div>
        <the-new-journal-entry-dialog internship-end-date="2021-01-23"></the-new-journal-entry-dialog>
        <v-row v-if="isLoadingJournalEntryCards">
            <v-col
                cols="12"
                class="d-flex justify-center mt-5"
            >
                <v-progress-circular
                    indeterminate
                    color="#262A34"
                    size="60"
                ></v-progress-circular>
            </v-col>
        </v-row>
        <v-row v-else-if="journalEntries.length === 0">
            <v-col cols="12">
                <the-empty-journal-list-message></the-empty-journal-list-message>
            </v-col>
        </v-row>
        <v-row v-else>
            <v-col cols="12">
                <JournalEntrySmallCard
                    v-for="journalEntry in journalEntries" :key="journalEntry.id"
                    :content="journalEntry.content"
                ></JournalEntrySmallCard>
            </v-col>
        </v-row>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";
    import moment from "moment";
    import TheEmptyJournalListMessage from "./TheEmptyJournalListMessage";
    import JournalEntrySmallCard from "./JournalEntrySmallCard";
    import TheNewJournalEntryDialog from "./TheNewJournalEntryDialog";
    import JournalFormModal from "./JournalFormModal";
    import JournalsList from "./JournalsList";
    import PageDetailsHeader from "../Page/PageDetailsHeader";

    export default {
        name: "TheJournalEntriesList",

        components: {
            TheEmptyJournalListMessage,
            JournalEntrySmallCard,
            TheNewJournalEntryDialog,
            JournalFormModal,
            JournalsList,
            PageDetailsHeader
        },

        data() {
            return {
                isLoadingJournalEntryCards: true,
                percentOfInternship: null,
            }
        },

        computed: {
            ...mapGetters({
                journalEntries: 'student/studentJournalEntries',
            })
        },

        methods: {
            ...mapActions({
                fetchJournalEntries: 'student/fetchStudentJournalEntries',
            }),

            getPercentOfInternship(internshipStartDate, internshipEndDate) {
                let allInternshipDays = (moment(internshipEndDate).diff(moment(internshipStartDate), 'days')) + 1;
                let internshipsDaysToToday = (moment().diff(moment(internshipStartDate), 'days')) + 1;

                return Math.round(Math.min(((internshipsDaysToToday / allInternshipDays) * 100), 100));
            },

            formatDate(date, format = 'DD.MM.YYYY') {
                return moment(date).format(format);
            },
        },

        created() {
            this.fetchJournalEntries({internshipId: 1, studentIndex: this.$route.params.studentIndex}).then(() => {
                this.isLoadingJournalEntryCards = false;
                this.percentOfInternship = this.getPercentOfInternship(this.journalEntries[0].internship.agreement.date_from, this.journalEntries[0].internship.agreement.date_to);
            });
        }
    }
</script>

<style scoped>

</style>
