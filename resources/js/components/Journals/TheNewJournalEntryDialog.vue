<template>
    <v-dialog
        v-model="dialog"
        fullscreen
        transition="dialog-bottom-transition"
        content-class="mt-20"
    >
        <template v-slot:activator="{ on, attrs }">
            <v-row>
                <v-col cols="12">
                    <v-card
                        color="cardBackground"
                        elevation="0"
                        class="pa-3 text-center"
                        v-bind="attrs"
                        v-on="on"
                    >
                        <v-icon>mdi-plus</v-icon>
                    </v-card>
                </v-col>
            </v-row>
        </template>
        <v-card color="navBackground" class="rounded-t-lg">
            <v-container fluid>
                <v-row class="px-3">
                    <v-col cols="12">
                        <h2>Nowy wpis</h2>
                    </v-col>
                </v-row>
                <v-form>
                    <v-row class="px-3">
                        <v-col cols="12">
                            <v-menu
                                v-model="dateMenu"
                                :close-on-content-click="false"
                                :nudge-right="40"
                                transition="scale-transition"
                                offset-y
                                min-width="auto"
                            >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                        v-model="journalEntry.createdAt"
                                        label="Data wpisu"
                                        readonly
                                        outlined
                                        full-width
                                        hide-details
                                        v-bind="attrs"
                                        v-on="on"
                                        hint="YYYY-MM-DD format"
                                    ></v-text-field>
                                </template>
                                <v-date-picker
                                    v-model="journalEntry.createdAt"
                                    @input="dateMenu = false"
                                    :min="minJournalEntryDate"
                                    :max="maxJournalEntryDate"
                                    show-current
                                    locale="pl-pl"
                                ></v-date-picker>
                            </v-menu>
                        </v-col>
                    </v-row>
                    <v-row class="px-3">
                        <v-col cols="12">
                            <v-textarea
                                v-model="journalEntry.content"
                                outlined
                                name="input-7-4"
                                label="Treść wpisu"
                                placeholder="Przykładowa treść wpisy do dziennika praktyk..."
                                rows="10"
                                full-width
                                hide-details
                            ></v-textarea>
                        </v-col>
                    </v-row>
                    <v-row class="px-3">
                        <v-col cols="12">
                            <v-btn
                                block
                                color="primary"
                                large
                            >
                                Dodaj wpis
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-form>
            </v-container>
        </v-card>
    </v-dialog>
</template>

<script>
    import moment from "moment";

    export default {
        name: "TheNewJournalEntryDialog",
        props: ['internshipEndDate', 'internshipId'],

        data() {
            return {
                dialog: false,
                dateMenu: false,
                minJournalEntryDate: null,
                maxJournalEntryDate: null,
                journalEntry: {
                    internshipId: null,
                    content: null,
                    userId: null,
                    createdAt: null,
                },
            }
        },

        created() {
            let internshipEndDate = moment() < moment(this.internshipEndDate) ? moment() : moment(this.internshipEndDate);

            this.journalEntry.createdAt = internshipEndDate.format('YYYY-MM-DD');
            this.maxJournalEntryDate = internshipEndDate.format('YYYY-MM-DD');
            this.minJournalEntryDate = internshipEndDate.subtract(7, 'days').format('YYYY-MM-DD');

            this.journalEntry.internshipId = this.internshipId;
        }
    }
</script>

<style lang="scss" scoped>

</style>
