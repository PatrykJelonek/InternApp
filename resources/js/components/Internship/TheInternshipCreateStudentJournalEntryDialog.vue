<template>
    <v-dialog v-model="dialog" max-width="600">
        <template v-slot:activator="{ on, attrs }">
            <v-btn
                icon
                v-on="on"
                v-bind="attrs"
            >
                <v-icon>mdi-plus</v-icon>
            </v-btn>
        </template>

        <custom-card>
            <custom-card-title>
                <template v-slot:default>Nowy wpis</template>
                <template v-slot:subheader>Formularz dodawania wpisu do dziennika praktyk.</template>
                <template v-slot:actions>
                    <v-btn icon @click="dialog = false">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </template>
            </custom-card-title>

            <v-form class="pa-5">
                <v-row>
                    <v-col cols="12">
                        <v-menu
                            v-model="datePicker"
                            :close-on-content-click="false"
                            :nudge-right="40"
                            transition="scale-transition"
                            offset-y
                            min-width="auto"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                    v-model="journalEntry.date"
                                    label="Data wpisu"
                                    readonly
                                    outlined
                                    hide-details="auto"
                                    v-bind="attrs"
                                    v-on="on"
                                    dense
                                    persistent-hint
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                v-model="journalEntry.date"
                                @input="datePicker = false"
                                :min="minJournalEntryDate"
                                :max="maxJournalEntryDate"
                                show-current
                                locale="pl-pl"
                            ></v-date-picker>
                        </v-menu>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <v-textarea
                            v-model="journalEntry.content"
                            outlined
                            label="Treść wpisu"
                            placeholder="Przykładowa treść wpisy do dziennika praktyk..."
                            dense
                            rows="5"
                            hide-details="auto"
                            persistent-hint
                        ></v-textarea>
                    </v-col>
                </v-row>
                <v-row v-has="['admin','university_worker','company_worker']">
                    <v-col cols="12">
                        <v-select
                            v-model="journalEntry.students_ids"
                            :items="internshipStudents"
                            :item-text="(item) => item.user.first_name + ' ' + item.user.last_name"
                            item-value="id"
                            label="Studenci"
                            multiple
                            outlined
                            dense
                            small-chips
                            chips
                            hide-details="auto"
                            hint="Wybierz studentów dla których ma zostać dodany ten wpis..."
                            persistent-hint
                        ></v-select>
                    </v-col>
                </v-row>
            </v-form>

            <custom-card-footer>
                <template v-slot:right>
                    <v-btn color="primary" outlined @click="submit">Dodaj wpis</v-btn>
                </template>
            </custom-card-footer>
        </custom-card>
    </v-dialog>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import moment from "moment";
import CustomCard from "../_General/CustomCard";
import CustomCardTitle from "../_General/CustomCardTitle";
import CustomCardFooter from "../_General/CustomCardFooter";

export default {
    name: "TheInternshipCreateStudentJournalEntryDialog",
    components: {CustomCardFooter, CustomCardTitle, CustomCard},
    props: ['internshipEndDate'],

    data() {
        return {
            dialog: false,
            datePicker: false,
            minJournalEntryDate: null,
            maxJournalEntryDate: null,
            label: 'ABC',
            journalEntry: {
                date: null,
                user_id: null,
                internship_id: null,
                content: null,
                students_ids: [],
            }
        }
    },

    computed: {
        ...mapGetters({
            currentUser: 'auth/user',
            internshipStudents: 'internship/internshipStudents',
            internship: 'internship/internship',
        })
    },

    methods: {
        ...mapActions({
            createStudentJournalEntry: 'student/createStudentJournalEntry',
            setSnackbar: 'snackbar/setSnackbar',
            addStudentJournalEntry: 'student/addStudentJournalEntry',
            toggleDialog: 'helpers/toggleDialog',
            fetchStudentJournalEntries: 'student/fetchStudentJournalEntries',
        }),

        getStudentIdByStudentIndex(studentIndex) {
            if (this.internshipStudents.length > 0) {
                this.internshipStudents.forEach((student) => {

                    if (student.student_index === studentIndex) {
                        return student.id;
                    }
                });
            }
        },

        clearJournalEntry() {
            this.journalEntry = {
                date: null,
                user_id: null,
                internship_id: null,
                content: null,
                students_ids: [],
            };
        },

        async submit() {
            await this.createStudentJournalEntry({
                'internshipId': this.$route.params.internshipId,
                'studentIndex': this.$route.params.studentIndex,
                'journalEntry': this.journalEntry
            }).then((journalEntry) => {
                this.dialog = false;
                this.clearJournalEntry();
                this.fetchStudentJournalEntries({
                    internshipId: this.$route.params.internshipId,
                    studentIndex: this.$route.params.studentIndex
                }).then(() => {

                }).catch((e) => {
                    console.error(e);
                })
                this.setSnackbar({message: 'Wpis został dodany!', color: 'success'});
                this.addStudentJournalEntry(journalEntry);
            }).catch((e) => {
                this.setSnackbar({message: 'Nie udało się dodać wpisu!', color: 'error'});
            });
        }
    },

    created() {
        let internshipEndDate = moment() < moment(this.internship.agreement.date_to) ? moment() : moment(this.internship.agreement.date_to);
        this.maxJournalEntryDate = internshipEndDate.format('YYYY-MM-DD');
        this.minJournalEntryDate = internshipEndDate.subtract(7, 'days').format('YYYY-MM-DD');

        this.journalEntry.user_id = this.currentUser.id;
        this.journalEntry.internship_id = this.$route.params.internshipId;

        if (this.$route.params.studentIndex) {
            //this.journalEntry.students_ids.push(this.getStudentIdByStudentIndex(this.$route.params.studentIndex));
        }
    }
}
</script>

<style scoped>

</style>
