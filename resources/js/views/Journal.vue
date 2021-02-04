<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12">
                <v-card color="cardBackground">
                    <v-card-title>Furgonetka</v-card-title>
                    <v-card-subtitle>11.11.2020 - 01.01.2021</v-card-subtitle>
                    <v-progress-linear
                        :value="percentOfInternship"
                        :indeterminate="percentOfInternship === null"
                        :color="percentOfInternship === null ? '#262A34' : percentOfInternship >= 100 ? 'success' : 'primary'"
                    ></v-progress-linear>
                </v-card>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <h2 class="text-m">
                    <v-icon>mdi-text-box-multiple-outline</v-icon>
                    Wpisy
                </h2>
            </v-col>
        </v-row>
        <the-new-journal-entry-dialog internship-end-date="2021-01-23"></the-new-journal-entry-dialog>
        <v-row v-if="isLoadingJournalEntryCards">
            <v-col cols="12" class="d-flex justify-center mt-5">
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
                    internship-start-date="2020-01-30"
                    journal-entry-date="2020-01-30"
                ></JournalEntrySmallCard>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";
    import PageDetailsHeader from "../components/Page/PageDetailsHeader";
    import JournalsList from "../components/Journals/JournalsList";
    import JournalFormModal from "../components/Journals/JournalFormModal";
    import TheNewJournalEntryDialog from "../components/Journals/TheNewJournalEntryDialog";
    import JournalEntrySmallCard from "../components/Journals/JournalEntrySmallCard";
    import TheEmptyJournalListMessage from "../components/Journals/TheEmptyJournalListMessage";
    import moment from "moment";

    export default {
        name: "Journal",

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
                journalEntries: 'user/journalEntries',
            })
        },

        methods: {
            ...mapActions({
                fetchJournalEntries: 'user/fetchJournalEntries',
            }),

            getPercentOfInternship(internshipStartDate, internshipEndDate) {
                let allInternshipDays = (moment(internshipEndDate).diff(moment(internshipStartDate), 'days'))+1;
                let internshipsDaysToToday = (moment().diff(moment(internshipStartDate), 'days'))+1;

                return Math.round(Math.min(((internshipsDaysToToday/allInternshipDays)*100), 100));
            }
        },

        created() {
            this.fetchJournalEntries().then(() => {
                this.isLoadingJournalEntryCards = false;
                this.percentOfInternship = this.getPercentOfInternship('2020-10-05','2021-01-23');
            });
        }
    }
</script>

<style lang="scss" scoped>

</style>
