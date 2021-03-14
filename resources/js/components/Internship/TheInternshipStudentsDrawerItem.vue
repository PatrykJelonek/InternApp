<template>
    <v-list-item
        link
        dense
        class="px-2"
        @click="onClick"
    >
        <v-list-item-avatar
            rounded
            :color="$route.params.studentIndex === index ? 'primary white--text' : 'secondary white--text'"
        >
            {{ firstname[0] + '' + lastname[0] }}
        </v-list-item-avatar>
        <v-list-item-content>
            <v-list-item-title> {{ firstname + ' ' + lastname }}</v-list-item-title>
            <v-list-item-subtitle>{{ index }}</v-list-item-subtitle>
        </v-list-item-content>
        <v-list-item-action>
            <v-btn icon>
                <v-icon color="grey lighten-1">mdi-information</v-icon>
            </v-btn>
        </v-list-item-action>
    </v-list-item>
</template>

<script>
import router from "../../router/routers";
import {mapActions} from "vuex";

export default {
    name: "TheInternshipStudentsDrawerItem",
    props: ['firstname', 'lastname', 'index'],
    data() {
        return {
            color: 'primary'
        }
    },
    methods: {
        ...mapActions({
            fetchStudentJournalEntries: 'student/fetchStudentJournalEntries',
            fetchStudentTasks: 'student/fetchStudentTasks',
        }),

        onClick() {
            router.push({name: 'internship-student', params: {studentIndex: this.index}});
            this.fetchStudentJournalEntries({internshipId: 1, studentIndex: this.index});
            this.fetchStudentTasks({internshipId: 1, studentIndex: this.index});
        },
    }
}
</script>

<style scoped>

</style>
