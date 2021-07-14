<template>
    <custom-card :loading="internshipStudentsLoading">
        <custom-card-title>
            <template v-slot:default>Lista studentów</template>
            <template v-slot:subheader>Wybierz jednego ze studentów z poniższej listy by zobaczyć jego wpisy i zadania w dzienniku praktyk.</template>
        </custom-card-title>
        <v-row v-if="!internshipStudentsLoading && internshipStudents.length > 0" no-gutters>
            <v-col cols="12" class="px-1 pt-3 pb-3">
                <v-slide-group center-active>
                    <internship-student
                        v-for="student in internshipStudents"
                        :key="student.id"
                        :fullname="student.user.first_name + ' ' + student.user.last_name"
                        :index="student.student_index"
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
import {mapGetters} from "vuex";
import InternshipStudentListItem from "./InternshipStudentListItem";
import InternshipStudent from "./InternshipStudent";
import CustomCard from "../_General/CustomCard";
import CustomCardTitle from "../_General/CustomCardTitle";

export default {
    name: "TheInternshipStudents",
    components: {CustomCardTitle, CustomCard, InternshipStudent, InternshipStudentListItem},
    data() {
        return {
            show: true,
            btnToggle: undefined,
        }
    },

    computed: {
        ...mapGetters({
            internship: 'internship/internship',
            internshipStudents: 'internship/internshipStudents',
            internshipStudentsLoading: 'internship/internshipStudentsLoading',
        })
    },

    created() {

    }
}
</script>

<style scoped>

</style>
