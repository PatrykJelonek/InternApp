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
                fetchJournalEntries: 'student/fetchStudentJournalEntries',
            }),

            cardOnClick() {
                router.push({ name: 'internship-student', params: { studentIndex: this.studentIndex } });
                this.fetchJournalEntries({internshipId: 1, studentIndex: this.studentIndex});
            },
        }
    }
</script>

<style scoped>

</style>
