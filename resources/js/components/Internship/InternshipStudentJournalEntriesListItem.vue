<template>
    <v-card
        color="cardBackground"
        elevation="0"
        class="mb-3"
        @click="cardOnClick"
    >
        <v-list flat two-line color="transparent">
            <v-list-item-group multiple>
                <v-list-item :ripple="false">
                    <v-list-item-content>
                        <v-list-item-title class="text-m font-weight-bold">
                            Dzień {{getInternshipDay(internshipStartDate, journalEntryDate)}}
                        </v-list-item-title>
                        <v-list-item-subtitle class="text-m">{{formatDate(journalEntryDate,'DD.MM.YYYY')}}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-list-item-group>
        </v-list>
        <v-dialog
            v-model="dialog"
            max-width="600px"
            class="mx-10"
        >
            <v-card
                class="pa-1"
                color="cardBackground"
            >
                <v-card-title>Abc</v-card-title>
                <v-card-subtitle>Data: {{formatDate(journalEntryDate,'DD.MM.YYYY')}}</v-card-subtitle>
                <v-card-text>{{content}}</v-card-text>
            </v-card>
        </v-dialog>
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
