<template>
    <v-card elevation="0" color="card-background" :loading="loadingStudentTasks">
        <template slot="progress">
            <v-progress-linear color="primary" indeterminate></v-progress-linear>
        </template>
        <v-list color="card-background">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="text-h5 font-weight-medium">Zadania</v-list-item-title>
                    <v-list-item-subtitle>Lista zadań przypisanych do wybranego studenta.</v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-action>
                    <v-btn-toggle dense borderless color="card-background">
                        <the-internship-create-student-task-dialog></the-internship-create-student-task-dialog>
                        <v-btn
                            icon
                            @click="show = !show"
                            v-if="this.$route.params.studentIndex && !loadingStudentTasks && studentTasks.length > 0"
                        >
                            <v-icon>{{ show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                        </v-btn>
                    </v-btn-toggle>
                </v-list-item-action>
            </v-list-item>
        </v-list>
        <v-divider></v-divider>
        <v-expand-transition v-if="this.$route.params.studentIndex && !loadingStudentTasks && studentTasks.length > 0">
            <v-row v-show="show">
                <v-col cols="12">
                    <v-list nav color="card-background">
                        <internship-student-task
                            v-for="task in displayedTasks"
                            :key="task.id"
                            :name="task.name"
                            :description="task.description"
                            :done="task.done"
                        ></internship-student-task>
                    </v-list>
                </v-col>
                <v-col cols="12" v-if="studentTasks.length > perPage">
                    <v-pagination
                        v-model="page"
                        :length="Math.ceil(studentTasks.length/perPage)"
                        :total-visible="totalVisible"
                    ></v-pagination>
                </v-col>
            </v-row>
        </v-expand-transition>
        <v-row v-else-if="this.$route.params.studentIndex && !loadingStudentTasks">
            <v-col cols="12" class="text-center pt-8">
                <p class="text--secondary">Ten student nie ma jeszcze przypisanych zadań.</p>
            </v-col>
        </v-row>
        <v-row v-else>
            <v-col cols="12" class="text-center pt-8">
                <p class="text--secondary">Nie wybrano studenta.</p>
            </v-col>
        </v-row>
    </v-card>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import InternshipStudentTask from "./InternshipStudentTask";
import TheInternshipCreateStudentTaskDialog from "./TheInternshipCreateStudentTaskDialog";

export default {
    name: "TheInternshipStudentTasks",
    components: {TheInternshipCreateStudentTaskDialog, InternshipStudentTask},
    data() {
        return {
            show: true,
            page: 1,
            perPage: 5,
            totalVisible: 5,
        }
    },

    computed: {
        ...mapGetters({
            studentTasks: 'student/studentTasks',
            loadingStudentTasks: 'student/loadingStudentTasks',
        }),

        displayedTasks() {
            return this.studentTasks.slice((this.page - 1) * this.perPage, this.page * this.perPage);
        },
    },

    methods: {
        ...mapActions({
            fetchStudentTasks: 'student/fetchStudentTasks'
        }),
    },

    created() {
        if (this.$route.params.studentIndex !== null) {
            this.fetchStudentTasks({
                internshipId: 1,
                studentIndex: this.$route.params.studentIndex
            }).then(() => {

            }).catch((e) => {
                console.error(e);
            })
        }
    }
}
</script>

<style scoped>

</style>
