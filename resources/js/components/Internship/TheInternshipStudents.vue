<template>
    <v-card elevation="0" color="card-background" :loading="internshipStudentsLoading">
        <template slot="progress">
            <v-progress-linear color="primary" indeterminate></v-progress-linear>
        </template>
        <v-card-title>Lista studentów</v-card-title>
        <v-card-subtitle>Wybierz jednego ze studentów z poniższej listy by zobaczyć jego wpisy i zadania w dzienniku praktyk.</v-card-subtitle>
        <v-divider></v-divider>
        <v-row v-if="!internshipStudentsLoading && internshipStudents.length > 0">
            <v-col cols="12" class="px-3 pt-8 pb-5">
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
    </v-card>
</template>

<script>
import {mapGetters} from "vuex";
import InternshipStudentListItem from "./InternshipStudentListItem";
import InternshipStudent from "./InternshipStudent";

export default {
    name: "TheInternshipStudents",
    components: {InternshipStudent, InternshipStudentListItem},
    data() {
        return {
            show: true,
            btnToggle: undefined,
        }
    },

    computed: {
        ...mapGetters({
            internshipStudents: 'internship/internshipStudents',
            internshipStudentsLoading: 'internship/internshipStudentsLoading',
        })
    },
}
</script>

<style scoped>

</style>
