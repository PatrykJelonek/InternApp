<template>
    <v-dialog v-model="dialog" max-width="500">
        <template v-slot:activator="{ on, attrs }">
            <v-card
                class="pa-3 mb-3 text-center"
                color="cardBackground"
                v-bind="attrs"
                elevation="0"
                v-on="on"
                ripple
            >
                <v-icon>mdi-plus</v-icon>
            </v-card>
        </template>
        <v-card color="cardBackground" class="pa-5">
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
                        v-model="journalEntry.students"
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
                    >
                        Dodaj wpis
                    </v-btn>
                </v-col>
            </v-row>
        </v-card>
    </v-dialog>
</template>

<script>
    import InternshipDialogActivator from "../_Helpers/InternshipDialogActivator";
    import moment from "moment";
    import {mapGetters} from "vuex";

    export default {
        name: "TheInternshipCreateStudentJournalEntryDialog",
        props: ['internshipEndDate'],
        components: {InternshipDialogActivator},

        computed: {
            ...mapGetters({
                currentUser: 'auth/user',
                internshipStudents: 'internship/internshipStudents'
            })
        },

        data() {
            return {
                dialog: false,
                datePicker: false,
                minJournalEntryDate: null,
                maxJournalEntryDate: null,
                journalEntry: {
                    date: null,
                    user_id: null,
                    internship_id: null,
                    content: null,
                    students: [],
                }
            }
        },

        methods: {
            getStudentIdByStudentIndex(studentIndex) {
                if(this.internshipStudents.length > 0) {
                    this.internshipStudents.forEach((student) => {
                        console.log(student);
                       if(student.student_index === studentIndex) {
                           return student.id;
                       }
                    });
                }
            }
        },

        created() {
            let internshipEndDate = moment() < moment(this.internshipEndDate) ? moment() : moment(this.internshipEndDate);
            this.maxJournalEntryDate = internshipEndDate.format('YYYY-MM-DD');
            this.minJournalEntryDate = internshipEndDate.subtract(7, 'days').format('YYYY-MM-DD');

            this.journalEntry.user_id = this.currentUser.id;
            this.journalEntry.internship_id = this.$route.params.inernshipId;

            if(this.$route.params.studentIndex) {
                console.log(this.$route.params.studentIndex);
                this.journalEntry.students.push(this.getStudentIdByStudentIndex(this.$route.params.studentIndex));
            }
        }
    }
</script>

<style scoped>

</style>
