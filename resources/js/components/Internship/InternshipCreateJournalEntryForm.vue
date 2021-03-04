<template>
    <v-form>
        <v-row>
            <v-col cols="12">
                <h3>Nowy wpis</h3>
            </v-col>
        </v-row>
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
                            full-width
                            hide-details
                            v-bind="attrs"
                            v-on="on"
                            hint="YYYY-MM-DD format"
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
                    name="input-7-4"
                    label="Treść wpisu"
                    placeholder="Przykładowa treść wpisy do dziennika praktyk..."
                    rows="10"
                    full-width
                    hide-details
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
                    chips
                    hint="Wybierz studentów dla których ma zostać dodany ten wpis..."
                    persistent-hint
                ></v-select>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <v-btn
                    block
                    color="primary"
                    large
                    @click="submit"
                >
                    Dodaj wpis
                </v-btn>
            </v-col>
        </v-row>
    </v-form>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import moment from "moment";

export default {
    name: "InternshipCreateJournalEntryForm",
    props: ['internshipEndDate'],

    data() {
        return {
            datePicker: false,
            minJournalEntryDate: null,
            maxJournalEntryDate: null,
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
            internshipStudents: 'internship/internshipStudents'
        })
    },

    methods: {
        ...mapActions({
            createStudentJournalEntry: 'student/createStudentJournalEntry',
            setSnackbar: 'snackbar/setSnackbar',
            addStudentJournalEntry: 'student/addStudentJournalEntry',
            toggleDialog: 'helpers/toggleDialog',
        }),

        getStudentIdByStudentIndex(studentIndex) {
            if (this.internshipStudents.length > 0) {
                console.log(this.internshipStudents);
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
                this.toggleDialog();
                this.clearJournalEntry();
                this.setSnackbar({message: 'Wpis został dodany!', color: 'success'});
                this.addStudentJournalEntry(journalEntry);
            }).catch((e) => {
                this.setSnackbar({message: 'Nie udało się dodać wpisu!', color: 'error'});
            });
        }
    },

    created() {
        let internshipEndDate = moment() < moment(this.internshipEndDate) ? moment() : moment(this.internshipEndDate);
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
