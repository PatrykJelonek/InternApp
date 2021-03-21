<template>
    <v-card elevation="0">
        <v-card-title>Lista studentów</v-card-title>
        <v-card-subtitle>Wybierz jednego ze studentów z poniższej listy by zobaczyć jego wpisy i zadania w dzienniku praktyk.</v-card-subtitle>
        <v-divider></v-divider>
        <v-list nav>

        </v-list>
    </v-card>
</template>

<script>
import {mapGetters} from "vuex";
import InternshipStudentListItem from "./InternshipStudentListItem";

export default {
    name: "TheInternshipStudents",
    components: {InternshipStudentListItem},
    data() {
        return {
            show: true,
            btnToggle: undefined
        }
    },

    computed: {
        ...mapGetters({
            internshipStudents: 'internship/internshipStudents'
        })
    },
}
</script>

<style scoped>

</style>
