<template>
    <v-slide-item
        class="ml-5"
        v-slot="{ active, toggle }"
    >
        <v-card
            nav
            flat
            outlined
            width="250"
            @click="cardOnClick(); toggle();"
            :color="$route.params.studentIndex === index ? 'primary' : 'cardBackground'"
        >
            <v-list dense color="card-background">
                <v-list-item>
                    <v-list-item-content>
                        <v-list-item-title>{{ fullname }}</v-list-item-title>
                        <v-list-item-subtitle>{{ index }}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-card>
    </v-slide-item>
</template>

<script>
import router from "../../router/routers";
import {mapActions} from "vuex";

export default {
    name: "InternshipStudent",
    props: ['fullname', 'index'],

    methods: {
        ...mapActions({
            fetchStudentJournalEntries: 'student/fetchStudentJournalEntries',
            fetchStudentTasks: 'student/fetchStudentTasks',
        }),

        cardOnClick() {
            if (this.$route.params.studentIndex !== this.index) {
                router.push({name: 'internship-student', params: {studentIndex: this.index}});
                this.fetchStudentJournalEntries({internshipId: 1, studentIndex: this.index});
                this.fetchStudentTasks({internshipId: 1, studentIndex: this.index});
            }
        },
    }
}
</script>

<style scoped>

</style>
