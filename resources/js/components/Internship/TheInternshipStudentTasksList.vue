<template>
    <div>
        <template v-if="$route.params.studentIndex">
            <template v-if="studentTasks.length > 0 && !loadingStudentTasks">
                <internship-student-tasks-list-item
                    v-for="studentTask in studentTasks"
                    :key="studentTask.id"
                    :name="studentTask.name"
                    :description="studentTask.description"
                ></internship-student-tasks-list-item>
            </template>
            <template v-else-if="loadingStudentTasks">
                <div class="d-flex justify-center mt-5">
                    <v-progress-circular
                        indeterminate
                        color="#262A34"
                        size="60"
                    ></v-progress-circular>
                </div>
            </template>
            <template v-else>
                <h4 class="text-center">Wybrany student nie posiada zadań w&nbsp;dzienniku!</h4>
            </template>
        </template>
        <template v-else>
            <h4 class="text-center">Nie wybrano studenta!</h4>
        </template>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";
    import InternshipStudentTasksListItem from "./InternshipStudentTasksListItem";

    export default {
        name: "TheInternshipStudentTasksList",
        components: {InternshipStudentTasksListItem},
        computed: {
            ...mapGetters({
                studentTasks: 'student/studentTasks',
                loadingStudentTasks: 'student/loadingStudentTasks',
            })
        },

        methods: {
            ...mapActions({
                fetchStudentTasks: 'student/fetchStudentTasks'
            }),
        },

        created() {
            if(this.$route.params.studentIndex !== null) {
                this.fetchStudentTasks({internshipId: 1, studentIndex: this.$route.params.studentIndex}).then(() => {

                }).catch((e) => {
                    console.error(e);
                })
            }
        }
    }
</script>

<style scoped>

</style>
