<template>
    <v-card
        color="cardBackground"
        elevation="0"
        class="mb-3"
        @click="cardOnClick"
    >
        <v-expansion-panel-header>
            adssdasd
        </v-expansion-panel-header>
        <v-expansion-panel-content>
            asdas
        </v-expansion-panel-content>
    </v-card>
</template>

<script>
    import moment from "moment";
    import {mapActions} from "vuex";

    export default {
        name: "InternshipStudentJournalEntriesListItem",
        props: ['internshipStartDate', 'journalEntryDate', 'content'],

        data() {
            return {
                dialog: false,
            }
        },

        methods: {
            ...mapActions({
                setPreview: 'internship/setPreview'
            }),

            getInternshipDay: (internshipStartDate, journalEntryDate) => {
                return moment(journalEntryDate).diff(moment(internshipStartDate), 'days') + 1;
            },

            formatDate(date, format) {
                return moment(date).format(format);
            },

            cardOnClick() {
                if(this.$vuetify.breakpoint.lgAndUp) {
                    this.setPreview(this.content);
                } else {
                    this.dialog = !this.dialog;
                }
            }
        },
    }
</script>

<style scoped>

</style>
