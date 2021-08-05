<template>
    <custom-card :loading="loadingStudentTasks">
        <custom-card-title>
            <template v-slot:default>Zadania</template>
            <template v-slot:subheader>Lista zadań przypisanych do wybranego studenta.</template>
            <template v-slot:actions>
                <the-internship-create-student-task-dialog
                    v-if="$route.params.studentIndex && !internship.status.name.includes('ended_by_company', 'ended_by_university' , 'ended')"
                ></the-internship-create-student-task-dialog>
                <v-btn
                    icon
                    @click="show = !show"
                    v-if="$route.params.studentIndex && !loadingStudentTasks && studentTasks.length > 0"
                >
                    <v-icon>{{ show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                </v-btn>
            </template>
        </custom-card-title>

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
    </custom-card>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import InternshipStudentTask from "./InternshipStudentTask";
import TheInternshipCreateStudentTaskDialog from "./TheInternshipCreateStudentTaskDialog";
import CustomCard from "../_General/CustomCard";
import CustomCardTitle from "../_General/CustomCardTitle";

export default {
    name: "TheInternshipStudentTasks",
    components: {CustomCardTitle, CustomCard, TheInternshipCreateStudentTaskDialog, InternshipStudentTask},
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
            internship: 'internship/internship',
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
