<template>
    <custom-card :loading="internshipStudentsLoading">
        <internship-rate-student-dialog></internship-rate-student-dialog>
        <custom-card-title>
            <template v-slot:default>Lista studentów</template>
            <template v-slot:subheader>Wybierz jednego ze studentów z poniższej listy by zobaczyć jego wpisy i zadania w
                dzienniku praktyk.
            </template>
            <template v-slot:actions>
                <v-btn
                    outlined
                    color="primary"
                    v-if="!internshipStudentLoading && internship.status.name === 'ended_by_company' && internshipStudent.student.student_index != null && $route.params.studentIndex"
                    @click="toggleDialog({key: 'DIALOG_FIELD_RATE_STUDENT', val: true})"
                >
                    {{ internshipStudent.grade ? 'Zmień ocenę' : 'Wystaw ocenę' }}
                </v-btn>
            </template>
        </custom-card-title>
        <v-row v-if="!internshipStudentsLoading && internshipStudents.length > 0" no-gutters>
            <v-col cols="12" class="px-1 pt-3 pb-3">
                <v-slide-group center-active>
                    <internship-student
                        v-for="student in internshipStudents"
                        :key="student.id"
                        :fullname="student.user.first_name + ' ' + student.user.last_name"
                        :index="student.student_index"
                        :student="student"
                        :grade="student.grade"
                    ></internship-student>
                </v-slide-group>
            </v-col>
        </v-row>
        <v-row v-else-if="!internshipStudentsLoading">
            <v-col cols="12" class="text-center pt-8">
                <p class="text--secondary">Niestety do tej praktyki nie ma jeszcze przypisanych studentów.</p>
            </v-col>
        </v-row>
    </custom-card>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import InternshipStudentListItem from "./InternshipStudentListItem";
import InternshipStudent from "./InternshipStudent";
import CustomCard from "../_General/CustomCard";
import CustomCardTitle from "../_General/CustomCardTitle";
import InternshipRateStudentDialog from "./InternshipRateStudentDialog";

export default {
    name: "TheInternshipStudents",
    components: {InternshipRateStudentDialog, CustomCardTitle, CustomCard, InternshipStudent, InternshipStudentListItem},
    data() {
        return {
            show: true,
            btnToggle: undefined,
        }
    },

    computed: {
        ...mapGetters({
            student: 'student/student',
            internship: 'internship/internship',
            internshipStudents: 'internship/internshipStudents',
            internshipStudent: 'internship/internshipStudent',
            internshipStudentLoading: 'internship/internshipStudentLoading',
            internshipStudentsLoading: 'internship/internshipStudentsLoading',
        })
    },

    methods: {
        ...mapActions({
            toggleDialog: 'helpers/toggleDialog'
        }),
    },

    created() {

    }
}
</script>

<style scoped>

</style>
