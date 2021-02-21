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
                            <v-menu>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-icon v-bind="attrs" v-on="on">mdi-dots-vertical</v-icon>
                                </template>
                                <v-list dense>
                                    <v-list-item
                                        dense
                                        nudge-top="10px"
                                    >
                                        Pobierz Dziennik
                                    </v-list-item>
                                </v-list>
                            </v-menu>
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

    export default {
        name: "InternshipStudentListItem",
        props: ['studentFullName','studentIndex'],

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
