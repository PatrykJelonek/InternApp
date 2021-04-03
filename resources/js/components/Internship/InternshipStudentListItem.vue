<template>
    <v-card>
        <v-card
            :color="$route.params.studentIndex === studentIndex ? 'success' : 'cardBackground'"
            elevation="0"
            class="mb-3"
            @click="cardOnClick"
        >
            <v-list flat two-line color="transparent">
                <v-list-item-group multiple>
                    <v-list-item :ripple="false">
                        <v-list-item-content>
                            <v-list-item-title class="text-m font-weight-bold">{{studentFullName}}</v-list-item-title>
                            <v-list-item-subtitle>{{studentIndex}}</v-list-item-subtitle>
                        </v-list-item-content>
                        <v-list-item-action v-has="['admin','company_worker','university_worker']">
                            <internship-student-list-item-actions
                                    :internship-end-date="internshipEndDate"
                            ></internship-student-list-item-actions>
                        </v-list-item-action>
                    </v-list-item>
                </v-list-item-group>
            </v-list>
        </v-card>
    </v-card>
</template>

<script>
    import router from "../../router/routers";
    import {mapActions} from "vuex";
    import InternshipStudentListItemActions from "./InternshipStudentListItemActions";

    export default {
        name: "InternshipStudentListItem",
        components: {InternshipStudentListItemActions},
        props: ['studentFullName','studentIndex','internshipEndDate'],

        methods: {
            ...mapActions({
                fetchStudentJournalEntries: 'student/fetchStudentJournalEntries',
                fetchStudentTasks: 'student/fetchStudentTasks',
            }),

            cardOnClick() {
                router.push({ name: 'internship-student', params: { studentIndex: this.studentIndex } });
                this.fetchStudentJournalEntries({internshipId: 1, studentIndex: this.studentIndex});
                this.fetchStudentTasks({internshipId: 1, studentIndex: this.studentIndex});
            },
        }
    }
</script>

<style scoped>

</style>
